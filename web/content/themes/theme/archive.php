<?php

use Timber\Timber;
$context = Timber::context();
Timber::render('@app/pages/archive.twig', $context);
