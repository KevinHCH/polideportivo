<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Repository\AsisteRepository;
use App\Repository\ClaseRepository;
use App\Repository\PagoRepository;
use App\Repository\UsuarioRepository;
use App\Repository\GustosUsuariosRepository;
use App\Repository\ReservaRepository;
use App\Repository\PistaRepository;
use App\Repository\InstalacionRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax", name="ajax")
     */
    public function index(UsuarioRepository $em, GustosUsuariosRepository $gu )
    {
//        Obtener el ID de la sesion de nico
        $userSesion = new Session();
        $userSesion = $userSesion->getUser();
        
        $datosUsuario = $em->getDataUser($userSesion->getId());
        if (empty($datosUsuario)) {
            $datosUsuario = $em->getDataUserOnly($userSesion->getId());
        }
        $data = ($datosUsuario) ? $datosUsuario : "";
        return new JsonResponse( [ "user" => $datosUsuario ] );
    }

    /**
     * Funcion que recibira datos por POST desde una pagina html (ConfiguracionPerfil)
     * @Route("/ajax/data", name="ajax_data")
     */
    public function data(UsuarioRepository $em,  GustosUsuariosRepository $gu)
    {
        $data = "";
        if (count($_FILES) > 0) {
//                Si no devuelve el nombre de foto, devuelve un string vacio, la ruta de la img por defecto
//                se establece en la consulta
            $nombreFoto = ($this->getNombreFoto($_FILES)) ? $this->getNombreFoto($_FILES) : "";
            $em->updateIMG($_POST["id"], $nombreFoto);
            $this->crearDirectorio("imgs/" . $_POST["id"], $_FILES);
        }
        if (count($_POST) > 2) {
//            Modificar la query para que solo admita los valores que se entregan en getDataUser
            $data = $em->updateUser($_POST["id"],$_POST, $gu);
        }
        return new JsonResponse(['res' => $data]);
    }//data

    /** Funcion que creara la carpeta de Destino General y la carpeta
     * con el ID del usuario obtenido desde el formulario HTML
     * @param $ruta : Nombre de la carpeta que se creeara en la ruta establecida
     * @param $arr : Array de Files (bytes) que viene desde el formulario
     */
    protected function crearDirectorio($ruta, $arr)
    {
//        He tenido que cambiar la ruta de la carpeta por que
//        no conseguia encontrar la ruta del el HTML via ajax
//        $carpetaDestino = "../src/DataFixtures/";
//        Esta sentencia solo se ejecutara UNa VEZ en el servidor
//        mkdir($carpetaDestino."imgs");
//        mkdir("imgs");
//        $ruta = $carpetaDestino.$ruta;
        if (!file_exists($ruta)) {
            mkdir($ruta, 0777);
        }
        $this->guardarImagen($arr, $ruta);
    }

    /**Funcion que cambia la imagen subida de una ruta temporal a una
     * carpeta del servidor previamente creada
     * @param $arr : Array de Files en bytes que llega desde el FORM del HTML
     * @param $ruta : Ruta de destino en donde se guardara la img
     */
    protected function guardarImagen($arr, $ruta)
    {
        move_uploaded_file($arr['imagen']['tmp_name'], $ruta . "/" . $this->getNombreFoto($arr));
    }

    /** Funcion que obtiene el nombre que llega del Array de Files y lo cambia
     * por el nombre que queramos sin modificar la extension
     * @param $arr : Array de Files en bytes que llega desde el FORM del HTML
     * @return string: Devuelve el nuevo nombre de la IMG
     */
    protected function getNombreFoto($arr)
    {
        $nombre = "imagen_perfil";
//        El index de la imagen es "imagen" por que asi se ha establecido al enviar
//        datos desde el formulario
        $extension = strrpos($arr['imagen']['name'], ".");
        $extension = substr($arr['imagen']['name'], $extension);
        return $nombre . $extension;
    }

    /**
     * @Route("/ajax/getUserActivity", name="ajax_user")
     */
    public function getUserActivity(UsuarioRepository $em)
    {
//      Obtener el ID de la sesion de nico
        $userSesion = new Session();
        $userSesion = $userSesion->getUser();
        $data = $em->getUserActivity($userSesion->getId());
        return new JsonResponse(["activity" => $data]);
    }

    /**
     * @Route("/ajax/getProfesorActivity", name="ajax_profesor")
     */
    public function getProfesorActivity(UsuarioRepository $em)
    {
//      Obtener el ID de la sesion de nico
        $userSesion = new Session();
        $userSesion = $userSesion->getUser();
        $data = $em->getProfesorActivity($userSesion->getId());
        return new JsonResponse(["activity" => $data]);
    }

    /**
     * @Route("/ajax/getHorariosClase", name="ajax_horario")
     * @param ClaseRepository $clase
     */
    public function getClasesByName(ClaseRepository $clase, AsisteRepository $asiste)
    {
        $data = $clase->getDatosClaseByName($_POST["nombre_clase"]);
//        dump($data);die;
        $nUsuarios = $asiste->getUsuApuntados($_POST["id"]);
        return new JsonResponse(["datos" =>
            [
                "horariosClase" => $data,
                "nUsuarios" => $nUsuarios
            ]
        ]);
    }

    /**
     * @Route("/ajax/setReservaClase", name="ajax_reserva_clase")
     * @param ClaseRepository $clase
     */
    public function setReservaClase(AsisteRepository $asiste, PagoRepository $pago)
    {
        $data = $_POST["clase_id"];
        $usuario = new Session();
        $usuario = $usuario->getUser();
        $usuarioId = $usuario->getId();

        $datosInsert = ["clase_id" => $data, "usuario_id" => $usuarioId];

        $response = "";
//        Hago esta comprobacion por que al ser Ajax, al intentar redirigir desde php no lo renderiza.
//        Tengo que hacer flags para poder saber lo que ha hecho, segun lo que envie
//        hara una redireccion u otra
        if (!empty($pago->estaAbonado($usuarioId))) {//Si esta abonado, hago la reserva
            $asiste->setReservaClase($datosInsert);
            $response = "Insertado";
        } else { //Si no, redirijo al usuario hacia nuestros bonos
            $response = "noAbonado";
        }
        return new JsonResponse(["data" => $response]);

    }

    /**
     * @Route("/ajax/validacionReserva", name="ajax_instalaciones")
     * @param InstalacionRepository $insta
     */
    public function validacionReserva(ReservaRepository $reser, PistaRepository $pista, InstalacionRepository $inst)
    {
        $datosPista = $pista->getDatosPistaPorDeporte($_POST['nombre_deporte']);
        $ocupadas = [];
        for ($i = 0; $i < sizeof($datosPista); $i++) {
            $aux = $datosPista[$i]['id'];

            $disponibilidad = $reser->getDisponibilidad($aux, $_POST);
            if (!empty($disponibilidad)) {

                array_push($ocupadas, $disponibilidad[0]);
            }
        }

        if (sizeof($ocupadas) == 0) {


            $id = $datosPista[0]['id_instalacion_id'];
            $precio = $datosPista[0]['precio_hora'];
            $l = $inst->nombreInstalacionPorId($id);
            $lugar = $l[0]['nombre_instalacion'];

            $nombre = $_POST['nombre_deporte'];
            $horaI = $_POST['horaInicio'];
            $horaF = $_POST['horaFin'];
            $fecha = $_POST['fecha'];
            $id_pista = 1;
            return new JsonResponse(["datos" =>
                [
                    "nombre" => $nombre,
                    "lugar" => $lugar,
                    "fecha" => $fecha,
                    "inicio" => $horaI,
                    "fin" => $horaF,
                    "precio" => $precio,
                    "pista_id" => $id_pista,
                ]
            ]);
        } elseif (sizeof($ocupadas) == 3) {
            return new JsonResponse(["datos" =>
                [
                    "error" => "Lo siento, las pistas estan ocupadas.Elige otra fecha o hora.Gracias"
                ]
            ]);
        } else {
            $id_p = [1, 2, 3];
            for ($i = 0; $i < sizeof($ocupadas); $i++) {
                $key = array_search($ocupadas[$i]['pista_id'], $id_p);

                if ($key >= 0) {
                    unset($id_p[$key]);
                    $id_p = array_values($id_p);
                }
            }
            $id = $id_p[0];;
            $precio = $datosPista[0]['precio_hora'];
            $l = $inst->nombreInstalacionPorId($id);
            $lugar = $l[0]['nombre_instalacion'];

            $nombre = $_POST['nombre_deporte'];
            $horaI = $_POST['horaInicio'];
            $horaF = $_POST['horaFin'];
            $fecha = $_POST['fecha'];
            $id_pista = $id_p[0];
            return new JsonResponse(["datos" =>
                [
                    "nombre" => $nombre,
                    "lugar" => $lugar,
                    "fecha" => $fecha,
                    "inicio" => $horaI,
                    "fin" => $horaF,
                    "precio" => $precio,
                    "pista_id" => $id_pista,
                ]
            ]);

        }
    }//validacionReserva

    /**
     * @Route("/ajax/setReservaInstalacion", name="ajax_reserva_instalacion")
     *
     */
    public function setReservaInstalacion(ReservaRepository $reserva)
    {
        $usuario = new Session();
        $usuario = $usuario->getUser();
        $usuarioId = $usuario->getId();
        $data = "";
        $datosReservaInstalacion = [
            "id" => $usuarioId,
            "horaInicio" => $_POST["horaInicio"],
            "horaFin" => $_POST["horaFin"],
            "precio" => (double) $_POST["precio"],
            "fecha" => $_POST["fecha"],
            "id_pista" => $_POST["id_pista"]
        ];
        if (count($_POST) == 5){
            $session = new Session();
            $session->set("datosReservaInstalacion",$datosReservaInstalacion);
            $data = "pendientePago";
        }else{
            $data = "err";
        }

        return new JsonResponse(["data" => $data]);
    }


}
