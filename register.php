<?php

$REGISTER_LTI2 = array(
    "name" => "My videos"
    ,"FontAwesome" => "fa-video-camera"
    ,"short_name" => "My videos"
    ,"description" => "Shows a page welcome page to describe the benefits of having a My Videos tool on the user's homepage"
    ,"messages" => array("launch") // By default, accept launch messages..
    ,"privacy_level" => "public" // anonymous, name_only, public
    ,"license" => "Apache"
    ,"languages" => array(
        "English",
    )
    ,"source_url" => "https://github.com/cilt-uct/tsugi-welcome-to-my-videos"
    // For now Tsugi tools delegate this to /lti/store
    ,"placements" => array(
        /*
        "course_navigation", "homework_submission",
        "course_home_submission", "editor_button",
        "link_selection", "migration_selection", "resource_selection",
        "tool_configuration", "user_navigation"
        */
    )
    ,"screen_shots" => array(
        /* no screenshots */
    )
);
