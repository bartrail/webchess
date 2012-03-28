
if(console == undefined) {
    var console = {
        log : function() {}
    };
}

$(document).ready(function() {
   
//   console.log($('.piece'));
   
   $( ".piece" ).draggable({ 
       containment: "#board",
       snap: '.piece',
       start: function(event, ui) {
//           console.log("start", event, ui);
       },
       drag: function(event, ui) {
//           console.log("drag", event, ui);
       },
       stop: function(event, ui) {
//           console.log("end", event, ui);
       }
   });
   
   $('.field').droppable({
       accept: '.piece',
       drop: function(event, ui) {
           var $piece  = ui.draggable;
           var $target = $(this);
           
           $(this).effect('highlight');

           $.ajax({
               url: 'chessAjax.php',
               dataType: 'html',
               type: 'POST',
               data: {
                  gameId: $piece.data('gameid'),
                  piece: {
                      x: $piece.data('x'),
                      y: $piece.data('y'),
                      type: $piece.data('type'),
                      player: $piece.data('player')
                  },
                  targetField: {
                      x: $target.data('x'),
                      y: $target.data('y')
                  } 
               },
               success: function(data, status, xhr) {
                   console.log(data);
               }
           })
           
       }
   });
   
});