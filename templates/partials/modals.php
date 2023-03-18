<?php

//----------------------------------------------------------------------------------------------------------------------
get_template_part('templates/views/modal', null, [
    'id' => 'demo',
    'title' => '<span class="text-blue-450 px-2 sm:px-8 block inline-block max-w-[42rem]">' . 'Hello World!' . '</span>',
    'content' => 'Hi! I am modal content',
    //            'show_after' => 1000
]);