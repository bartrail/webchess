
if(console == undefined) {
    var console = {
        log : function() {}
    };
}

$(document).ready(function() {
   
   // dialogs for chess game
   
   var test = ["test", "lala"];
   console.log(test);
   
   function createOrLoadGame(dialog) {
    var create = true;

    $(dialog).find('input,select').each(function() {
        if($(this).val().length == 0) {
            create = false;
        }
    });

    if(create) {

        $.ajax({
            url: 'createGameAjax.php',
            type: 'POST',
            // take all form fields
            data: $(dialog).find('form').serialize(),
            success: function(data, status, xhr) {

                $('#gameWrapper').empty();
                $('#gameWrapper').append(data);

                initChess();

                $(dialog).dialog('close');
            }
        });

    }       
   }
   
   $('#loadGameDialog').dialog({
       autoOpen: false,
       modal: true,
       title: 'Load a Game',
       buttons: [
        {
            text: "Abort",
            click: function() { $(this).dialog("close"); }
        },
        {
            text: "Load",
            click: function() { 
                createOrLoadGame(this);
            }
        }           
       ]
   });
   $('#newGameDialog').dialog({
       autoOpen: false,
       modal: true,
       title: 'Start a new Game',
       buttons: [
        {
            text: "Abort",
            click: function() { $(this).dialog("close"); }
        },
        {
            text: "New Game",
            click: function() { 
                createOrLoadGame(this);
            }
        }           
       ]       
   });
   
   // buttons to open dialog
   $('#newGame').button({
       icons: {
          primary: "ui-icon-power"
       }
   }).click(function() {
      $( "#newGameDialog" ).dialog( "open" );
   })
   
   
   $('#loadGame').button({
       icons: {
          primary: "ui-icon-disk"
       }
   }).click(function() {
      $( "#loadGameDialog" ).dialog( "open" );
   })
   
   
   function initChess() {
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

        $('.field' ).droppable({
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
                        if(data != 'false') {
                            $('.field' ).droppable('destroy');
                            $('#board').empty();
                            $('#board').append(data);
                            initChess();                            
                        }
                    }
                })

            }
        });       
   }
   
   initChess();
   
});