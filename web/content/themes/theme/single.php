<?php

use Timber\Timber;
$context = Timber::context();
Timber::render('@app/pages/single.twig', $context);
