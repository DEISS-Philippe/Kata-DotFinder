$( document ).ready(function() {
    console.log( "ready!" );

    let attempt = [0, 0];
    let feedback = 2;
    let loop = 1;

    let loopThreshold = 150;

    $('#start').on('click', function(event) {
        console.log(loop);
        while(feedback !== 0) {
            (function myloop(loop) {
                setTimeout(function () {
                    let data = {
                        'type': 'attempt',
                        'attempt': attempt,
                        'feedback': feedback
                    };

                    if (feedback !== 0) {
                        $.ajax({
                            url : 'index.php',
                            type : 'POST',
                            data : data,
                            dataType : 'json',
                            success : function(data, statut){
                                //update table
                                console.log(data);
                                attempt = data[0];
                                feedback = data[1];
                                let className = '';

                                if (feedback === 0) {
                                    className = 'dot';
                                }
                                if (feedback === 1) {
                                    className = 'hotspot';
                                }
                                if (feedback === 2) {
                                    className = 'try';
                                }

                                $('*[data-position="'+ attempt[0] +':'+ attempt[1] +'"]').addClass(className);

                                let $attemptsNumberContainer = $('.attempts');
                                $attemptsNumberContainer.text(Number($attemptsNumberContainer.text()) + 1);
                            },
                            error : function(resultat, statut, erreur){
                                console.log('Unexcpected data received');
                                console.log(resultat);
                            }
                        });
                    }
                }, 100 * loop);
            })(loop++);

            if (loop >= loopThreshold) {
                console.log('threshold set to '+loopThreshold);
                break;
            }
        }
    })
});