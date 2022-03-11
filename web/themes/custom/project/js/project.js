/**
 * Custom behaviors.
 */
(function (Drupal, once) {
  const onceName = 'project';

  Drupal.behaviors.projectCustomThing = {
    attach: function attach(context) {
      once(onceName, context.querySelector('body')).forEach(function (body) {
        let count = body.querySelectorAll('div').length;
        console.log(`There are ${count} div on this page`);
      });
    },
    detach: function detach(context, settings, trigger) {
      if (trigger === 'unload') {
        once.remove(onceName, context.querySelector('body')).forEach(function (body) {
          console.log('Once removed from body', body);
        });
      }
    }
  };
})(Drupal, once);
