// JavaScript Document
$(document).ready(function(){
var todos =[];

$("#table_defensorias tbody tr").each(function(index) {
       //todos.push($(this).text());
        //$(this).find("td").eq(0).css("color","red")
        //colum_1.push($(this).find("td").eq(0).text());
        todos.push({
            colum_0: $(this).find("td").eq(0).text(),
            colum_1: $(this).find("td").eq(1).text()
        }); 
    });

//console.log(todos) //ok

$("#filter_def").keyup(function(){
    //console.log($(this).val());
    
    $("#table_defensorias tbody").html("");
   var srtSearch = $(this).val(); 
   //var filtrados = filtrar(todos, srtSearch);
   
    //var filtrados = _.filter(todos, function(txt){ return /+'srtSearch '+/gi.test(txt); });
    
    var filtrados = _.filter(todos, function(obj){ 
        return (
            (new RegExp(srtSearch,'gi')).test(obj.colum_0) ||
            (new RegExp(srtSearch,'gi')).test(obj.colum_1)
)            
            ; });
    
    //console.log(filtrados)
        
    for(var i=0;i<filtrados.length;i++){
        $('#table_defensorias tbody')
        .append('<tr>'+
        '<td>'+filtrados[i].colum_0+'</td>'+
        '<td>'+filtrados[i].colum_1+'</td>'+
        '<td>'+'</td>'+
        '<td>'+'</td>'+
        '</tr>');
    }

});

})