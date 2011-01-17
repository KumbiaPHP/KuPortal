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
 * Clase utilizada para cargar y verificar los permisos que tiene un usuario.
 * 
 * @package Seguridad
 * @license http://www.gnu.org/licenses/gpl.txt GNU GENERAL PUBLIC LICENSE version 3.
 * @author Henry Stivens Adarme Muñoz <henry.stivens@gmail.com>
 */
//Carga de modelos necesarios
Load::models('seguridad/usuario', 'seguridad/rol', 'seguridad/rol_recurso', 'seguridad/recurso');
//Carga la libreria ACL2
Load::coreLib('acl2');

class KuAcl {

    protected $adapter;

    /**
     * Carga los roles, rescursos, usuarios y permisos de la base de datos.
     */
    public function cargarPermisos() {

        $this->adapter = Acl2::factory();
        $rol = new Rol();
        $roles = $rol->find();

        foreach ($roles as $value) {
            $rol_recurso = new RolRecurso();
            $roles_recursos = $rol_recurso->find("conditions: rol_id=$value->id");
            $resources = array();

            foreach ($roles_recursos as $value2) {
                $resources[] = $value2->getRecurso()->url;
            }
            //Establece a que recursos tiene acceso un rol.
            $this->adapter->allow($value->nombre, $resources);
        }

        //Consulta los usuarios
        $usuario = new Usuario();
        $usuarios = $usuario->find();

        foreach ($usuarios as $value) {
            $this->adapter->user($value->id, array($value->getRol()->nombre));
        }
    }

    /**
     * Verifica que un usuario tenga acceso al recurso determinado.
     * 
     * @param String $resource
     * @param String $user
     * @return boolean 
     */
    public function check($resource, $user) {
        return $this->adapter->check($resource, $user);
    }

}

?>