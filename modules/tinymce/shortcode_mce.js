(function() {
  tinymce.PluginManager.add('CustomShortcodes', function( editor, url ) {
    editor.addButton( 'custom_shortcodes_button', {
      text: 'Shortcode-ok',
      icon: false,
			type: 'menubutton',
      menu:
      [
        {
          text: 'Piktogram rövid leírással',
          value: '[piktogram-rovid-leirassal kep=\'\' leiras=\'\']',
          onclick: function() {
            editor.insertContent(this.value());
          }
        },
        {
          text: 'Google térkép beágyazás',
          value: '[googlemaps src="https://www.google.com...."]',
          onclick: function() {
            editor.insertContent(this.value());
          }
        },
        {
  				text: 'YouTube beágyazás',
  				value: '[youtube videoid="xxxxxxxxxx"]',
  				onclick: function() {
  					editor.insertContent(this.value());
  				}
  			},
        {
          text: 'Gomb beágyazás',
          value: '[button link="http://valami.hu" szoveg="Gomb szövege" ujoldal="igen/nem"]',
          onclick: function() {
            editor.insertContent(this.value());
          }
        },
        {
          text: 'Kéthasábos elrendezés',
          value: kethasabos_elrendezes(),
          onclick: function() {
            editor.insertContent(this.value());
          }
        },
        {
          text: 'Háromhasábos elrendezés',
          value: haromhasabos_elrendezes(),
          onclick: function() {
            editor.insertContent(this.value());
          }
        },
        {
          text: 'Négyhasábos elrendezés',
          value: negyhasabos_elrendezes(),
          onclick: function() {
            editor.insertContent(this.value());
          }
        },
        {
          text: 'Oldalsáv a bal oldalon',
          value: oldalsavbaloldalon_elrendezes(),
          onclick: function() {
            editor.insertContent(this.value());
          }
        },
        {
          text: 'Oldalsáv a jobb oldalon',
          value: oldalsavjobboldalon_elrendezes(),
          onclick: function() {
            editor.insertContent(this.value());
          }
        }
      ]
    });
  });


  function kethasabos_elrendezes() {
    return '<div class="row"><div class="col-md-6">Valami szöveg</div><div class="col-md-6">Valami szöveg</div></div>';
  }

  function haromhasabos_elrendezes() {
    return '<div class="row"><div class="col-md-4">Valami szöveg</div><div class="col-md-4">Valami szöveg</div><div class="col-md-4">Valami szöveg</div></div>';
  }

  function negyhasabos_elrendezes() {
    return '<div class="row"><div class="col-md-3">Valami szöveg</div><div class="col-md-3">Valami szöveg</div><div class="col-md-3">Valami szöveg</div><div class="col-md-3">Valami szöveg</div></div>';
  }

  function oldalsavbaloldalon_elrendezes() {
    return '<div class="row left-sidebar"><div class="col-md-4">Valami szöveg</div><div class="col-md-8">Valami szöveg</div></div>';
  }

  function oldalsavjobboldalon_elrendezes() {
    return '<div class="row right-sidebar"><div class="col-md-8">Valami szöveg</div><div class="col-md-4">Valami szöveg</div></div>';
  }

})();
