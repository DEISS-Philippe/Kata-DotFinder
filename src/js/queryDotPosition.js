$( document ).ready(function() {
    console.log( "ready!" );

    let attempt = [0, 0];
    let result = 2;

    $('#start').on('click', function(event) {

        let data = {
            'type': 'attempt',
            'attempt': attempt
        };

        $.ajax({
            url : 'index.php',
            type : 'POST',
            data : data,
            dataType : 'json',
            success : function(data, statut){
                //update table
                console.log(data);
                attempt = data[0];
                result = data[1];
                let className = '';

                if (result === 0){
                    className = 'dot';
                }
                if (result === 1) {
                    className = 'hotspot';
                }
                if (result === 2) {
                    className = 'try';
                }

                $('*[data-position="'+ attempt[0] +':'+ attempt[1] +'"]').addClass(className)
            },
            error : function(resultat, statut, erreur){
                console.log('error');
                console.log(resultat);
            }
        });

    })
});