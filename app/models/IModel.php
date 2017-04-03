<?php
interface IModel {
    //Metodo para listar datos de la tabla
    function get($obj=null);
    
    //Metodo para insertar en la tabla
    function insert($obj);
    
    //Metodo para actualizar un registro
    function update($obj);
    
    //Metodo para eliminar un registro
    function delete($obj);
    
    //Metodo para traer la info de un solo registro
    function getById($obj);
}
