<?php

use Timber\Timber;

$context = Timber::context();
Timber::render('@app/pages/404.twig', $context);
