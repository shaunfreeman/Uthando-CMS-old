window.addEvent('domready', function() {

    if ($('coverlogin')) {
        var panel = new Fx.Tween('coverlogin', {duration: 'long'});

        var panelHeight = $('coverlogin').getHeight();

        panel.start('height', 0);

        $('show_panel').addEvent('click', function(e) {
            panel.start('height', panelHeight);
        });

        $('hide_panel').addEvent('click', function(e) {
            panel.start('height', 0);
        });
    }
});
