$(function(){
    $("#productos30").click(function(){
        $("#productos30").addClass("activo");
        $("#productos15").removeClass("activo");
        $("#cumpleanios").removeClass("activo");
        
        $("#tablaProductos30").show();
        $("#tablaProductos15").hide();
        $("#tablaCumpleanios").hide();
    });
    
    $("#productos15").click(function(){
        $("#productos15").addClass("activo");
        $("#productos30").removeClass("activo");
        $("#cumpleanios").removeClass("activo");
        
        $("#tablaProductos15").show();
        $("#tablaProductos30").hide();
        $("#tablaCumpleanios").hide();
    });
    
    $("#cumpleanios").click(function(){
        $("#cumpleanios").addClass("activo");
        $("#productos15").removeClass("activo");
        $("#productos30").removeClass("activo");
        
        $("#tablaCumpleanios").show();
        $("#tablaProductos15").hide();
        $("#tablaProductos30").hide();
    });
});

