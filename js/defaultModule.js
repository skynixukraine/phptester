/**
 * Created by alekseyyp on 24.07.15.
 */
var defaultModule = (function(){
    var form,
        textBox,
        resultsBox,
        variablesBox,
        textBoxSelector = "textarea",
        resultsSelector = "#results",
        variablesSelector = "#variables",
        formSelector    = "form",
        url             = "compiler.php";
    return {
        init: function() {

            form            = $( formSelector ),
            textBox         = form.find( textBoxSelector );
            resultsBox      = $( resultsSelector );
            variablesBox    = $( variablesSelector );
            form.submit( function() {

                defaultModule.submitForm();
                return false;

            });
            textBox.blur( defaultModule.submitForm );

        },
        submitForm : function() {

            var val = textBox.val();
            if ( val.length > 0 ) {

                $.ajax({
                    url     : url,
                    type    : 'POST',
                    data    : {val : val},
                    dataType: 'json',
                    headers : { WebAIS : true},
                    success : function ( response ) {

                        resultsBox.html( response.content );
                        variablesBox.html( response.variables );

                    }
                })

            }

        }
    }
})();