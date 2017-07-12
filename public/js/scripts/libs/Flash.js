/**
 * Created by Utilisateur on 12/07/2017.
 */
class Flash
{
    static display(message, type="danger")
    {
        var html = '<div title="Cliquez pour masquer le message" id="alert" class="alert js-alert alert-'+type+'">'+msg+'</div>';
        $('#alert').remove();
        $('body').append(html);
        $('#alert.js-alert').animate({'opacity': '+0.9'}, 200 );
        $('#alert.js-alert').delay(1500).animate({'opacity': '-1.2'}, 1000, function(){
            $(this).remove();
        });
    }

    static success()
    {
        var html = '<div id="alert" class="js-alert-success alert-sucess"><span class="glyphicon glyphicon-ok flash"></span></div>';
        $('.js-alert-success').remove();
        $('body').append(html);
        $('#alert.js-alert-success').animate({'opacity': '+0.8'}, 350 );
        $('#alert.js-alert-success').delay(500).animate({'opacity': '-1.2'}, 550, function(){
            $(this).remove();
        });
    }
}