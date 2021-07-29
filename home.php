<?php
require_once('../config.php');
include 'tool-config.php';

use \Tsugi\Core\LTIX;
use \Tsugi\Core\Settings;

// Retrieve the launch data if present
$LAUNCH = LTIX::requireData();

$menu = false; // We are not using a menu

// Start of the output
$OUTPUT->header();

include("tool-header.html");

$OUTPUT->bodyStart();

$OUTPUT->topNav($menu);

    $context = array();
    $providers  = $LAUNCH->ltiRawParameter('lis_course_section_sourcedid','none');
    $context_id = $LAUNCH->ltiRawParameter('context_id','none');

    $context['providers'] = array();
    $context['provider'] = 'none';

    if ($providers != $context_id) {
        // So we might have some providers to show
        $list = explode('+', $providers);

        if (count($list) == 1) {
            $context['provider'] = $list[0];
        } else {
            $context['providers'] = $list;
        }
    }

    // $context['course_title'] = $app['tsugi']->context->title;
    $context['email'] = $USER->email;
    $context['user'] = $USER->displayname;
    $context['submit'] = addSession( str_replace("\\","/",$CFG->getCurrentFileUrl('process.php')) );

    if ($tool['debug']) {
        echo '<pre>'; print_r($context); echo '</pre>';
    }
?>
    <section>

    <div class="row">
        <div class="col-md-1 col-sm-4 col-xs-6"></div>
        <div class="col-md-10 col-sm-4 col-xs-6">

            <h3 class="text-center">Welcome to My Videos</h3>
            <p class="text-center">"My Videos" is a personal workspace where you can manage your videos.</p>

            <div class="row">
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="card">
                        <div class="card text-center" style="margin: 5px; padding:5px;">
                            <div style="border-radius: 50%; width: 150px;height: 150px;position: relative;
                                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                                background-image: url(images/upload_videos.png); background-repeat: no-repeat;
                                background-size: cover;margin : 0px auto;">
                                <span class="text-center bg-primary" style="width: 40px;height: 40px;
                                        bottom: -2px;right: -2px;position: absolute; border-radius: 25px;
                                        color:white;padding: 8px;">
                                    <i class="fa fa-upload"></i>
                                </span>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">Upload videos<br/>
                                <small>You can upload videos from your desktop.</small></h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="card text-center" style="margin: 5px; padding:5px;">
                        <div style="border-radius: 50%; width: 150px;height: 150px;position: relative;
                        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                        background-image: url(images/record_videos.png); background-repeat: no-repeat;
                        background-size: cover;margin : 0px auto;">
                             <span class="text-center bg-primary" style="width: 40px;height: 40px;
                                    bottom: -2px;right: -2px;position: absolute; border-radius: 25px;
                                    color:white;padding: 8px;">
                                <i class="fa fa-video"></i>
                             </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Record videos<br/>
                            <small>You can record videos from your desktop or using Opencast Studio.</small></h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="card text-center" style="margin: 5px; padding:5px;">
                       <div style="border-radius: 50%; width: 150px;height: 150px; position: relative;
                           box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                           background-image: url(images/manage_videos.png); background-repeat: no-repeat;
                           background-size: cover;margin : 0px auto;">
                           <span class="text-center bg-primary" style="width: 40px;height: 40px;
                                   bottom: -2px;right: -2px;position: absolute; border-radius: 25px;
                                   color:white;padding: 8px;">
                                <i class="fa fa-folder-open"></i>
                           </span>
                       </div>
                       <div class="card-body">
                            <h5 class="card-title">Manage Videos<br/>
                            <small>You can edit, watch and delete your videos.</small></h5>
                       </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="card text-center" style="margin: 5px; padding:5px;">
                        <div style="border-radius: 50%; width: 150px;height: 150px;position: relative;
                            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                            background-image: url(images/publish_videos.png); background-repeat: no-repeat;
                            background-size: cover;margin : 0px auto;">
                            <span class="text-center bg-primary" style="width: 40px;height: 40px;
                                    bottom: -2px;right: -2px;position: absolute; border-radius: 25px;
                                    color:white;padding: 8px;">
                                <i class="fa fa-location-arrow"></i>
                            </span>
                        </div>
                        <div class="card-body">

                            <h5 class="card-title">Publish videos<br/>
                            <small>You can publish your videos to other sites.</small></h5>
                        </div>
                    </div>
                </div>
            </div>

            <form class="form-inline text-center" method="post" target="_self" id="metadata">
                <input type="hidden" name="type"  id="type" value="remove"/>
                <input type="hidden" id="organizer" name="organizer" value="<?= $context['email'] ?>
                (<?= $context['user'] ?>)"/>
                <input type="hidden" name="presenters" id="presenters" value="<?= $context['user'] ?>"/>

                <?php
                    if (count($context['providers']) > 1) {
                ?>
                <div class="row">
                    <div class="col-md-3 hidden-sm hidden-xs">
                        <label for="presenters">Primary Course</label>
                    </div>
                    <div class="col-xs-12 col-sm-11 hidden-md hidden-lg">
                        <label for="presenters">Primary Course</label>
                    </div>
                    <div class="col-md-8 col-xs-12 col-sm-11 col-md-offset-0">
                        <select class="form-control" name="provider" id="provider">
                        <?php
                            foreach ($context['providers'] as $p) {
                                print "<option value=\"". $p ."\">". $p ."</option>";
                            }
                        ?>
                        </select>
                    </div>
                </div>
                <?php
                    } else {
                        print "<input type=\"hidden\" name=\"provider\" id=\"provider\" value=\"". $context['provider'] ."\"/>";
                    }
                ?>

                <button id="btnAccept" class="btn btn-success" type="button"><i class="fa fa-check"></i> Activate My Videos</button>
                <span id="info" class="text-info" style="display:none;"><small>This might take a couple of seconds.</small></span>
                <div class="col-xs-12" id="message"></div>
            </form>
            </div>
            <div class="col-md-1 col-sm-4 col-xs-6"></div>
        </div>
    </section>
<?php

$OUTPUT->footerStart();

?>
<!-- Our main javascript file for tool functions -->
<script>
    $(function() {
        var timeout = null;

        function hideHelp() {
            clearTimeout(timeout);
            $('#info').hide();
        }
        function showError(a) {
            $('#' + a).html('<i class="fa fa-exclamation"></i> Error').addClass('disabled').attr('disabled', true);
            $('#message').html(`<p class="bg-danger">An error occurred while performing this action, please contact
            <a href="mailto:help@vula.uct.ac.za?subject=Vula - Please help with: My Videos Setup">
            help@vula.uct.ac.za</a><br/> or call 021-650-5500 weekdays 8:30 - 17:00.</p>`);
        }
        function doPost(a, text) {
            $('#' + a).html('<i class="fa fa-cog fa-spin"></i>' + text);
            timeout = setTimeout(function(){ $('#info').show(); }, 1200);

            var contributor = $('#presenters').val().trim().replace(/\r?\n/g, ', ');

            var data = {
                "contributor": (contributor.endsWith(', ') ? contributor.substring(0, contributor.length-2) : contributor),
                "course": 'personal'
            }

            var jqxhr = $.post('<?= $context['submit'] ?>', data, function(result) {
                hideHelp();
                console.log(result['done'] +' '+ (result['done'] === 1));
                if (result['done'] === 1) {
                    $('#' + a).html('<i class="fa fa-check"></i> Refreshing page ...');

                    // post refresh
                    setTimeout(function() { parent.postMessage(JSON.stringify({ subject: "lti.pageRefresh" }), "*"); }, 3000);
                } else {
                    showError(a);
                }
            }, 'json')
            .fail(function() {
                hideHelp();
                showError(a);
            })
            .always(function() {
                hideHelp();
            });
        }

        $('#btnAccept').click( function(event){
            event.preventDefault();
            doPost('btnAccept', 'Activating my videos...');
        });

    });
</script>
<?php

$OUTPUT->footerEnd();