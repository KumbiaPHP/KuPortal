<?php

/**
 * KuPortal - KumbiaPHP Portal
 * PHP version 5
 * LICENSE
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Controlador para listar, crear, editar y eliminar accesos.
 * 
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE version 3.
 * @author Henry Stivens Adarme Muñoz <henry.stivens@gmail.com>
 */
//Carga de modelos necesarios
Load::models('seguridad/rol_recurso','seguridad/rol','seguridad/recurso','seguridad/menu');

class AccesoController extends AdminController {
    
    /**
     * Variable para modificar el titulo.
     * @var string 
     */
    public $titulo = 'Accesos';

    public function index() {
        $rol = new Rol();
        $this->roles = $rol->find();
    }

    /**
     * Crea un Registro
     * @return Object RolRecurso  
     */
    public function crear() {
        if (Input::hasPost('rol_recurso')) {

            $obj = Load::model('rol_recurso');
            //En caso que falle la operación de guardar
            if (!$obj->save(Input::post('rol_recurso'))) {
                Flash::error('Falló operación');
                //se hacen persistente los datos en el formulario
                $this->rol_recurso = $obj;
                return;
            }
            return Router::redirect();
        }
        // Solo es necesario para el autoForm
        $this->rol_recurso = Load::model('rol_recurso');
    }

    /**
     * Edita un acceso.
     * @param int $id
     * @return Object RolRecurso 
     */
    public function editar($id) {

        //se verifica si se ha enviado via POST los datos
        if (Input::hasPost('rol_recurso')) {
            $obj = Load::model('rol_recurso');
            if (!$obj->update(Input::post('rol_recurso'))) {
                Flash::error('Falló operación');
                //se hacen persistente los datos en el formulario
                $this->rol_recurso = Input::post('rol_recurso');
            } else {
                return Router::redirect();
            }
        }

        //Aplicando la autocarga de objeto, para comenzar la edición
        $this->rol_recurso = Load::model('rol_recurso')->find((int) $id);
    }

    /**
     * Elimina un acceso.
     * @param int $id
     */
    public function borrar($id) {
        if (!Load::model('rol_recurso')->delete((int) $id)) {
            Flash::error('Falló Operación');
        }        
        Router::redirect();
    }

}
