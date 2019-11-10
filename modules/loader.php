<?php

  include_once 'settings.php';

  if( ENABLE_CUSTOM_POST_TYPES === TRUE ) {
    include_once 'vendor/CPT_Core.php';
  }

  if( ENABLE_CUSTOM_TAXONOMY === TRUE ) {
    include_once 'vendor/CT_Core.php';
  }

  if( ENABLE_CUSTOM_POST_TYPES_COLUMNS === TRUE ) {
    include_once 'vendor/CPT_Columns.php';
  }

  if( ENABLE_RESIZER == TRUE ) {
    include_once 'vendor/aq_resizer.php';
  }

  include_once 'core.php';

  if( ENABLE_DEVELOPER_WIDGET == TRUE ) {
    include_once 'extension/devwidgets.php';
  }

  include_once 'custom.php';

  include_once 'extra-options.php';

  include_once 'types/cpt-heroslider.php';