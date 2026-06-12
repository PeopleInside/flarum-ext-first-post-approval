flarum.extensions['peopleinside-flarum-ext-first-post-approval'] = {
  extend: [
    {
      extend: function(app) {
        app.extensionData
          .for('peopleinside-flarum-ext-first-post-approval')
          .registerSetting({
            setting: 'peopleinside-first-post-approval.approval_type',
            label: app.translator.trans('peopleinside-first-post-approval.admin.settings.approval_type_label'),
            type: 'select',
            options: {
              'all': app.translator.trans('peopleinside-first-post-approval.admin.settings.all_posts'),
              'first': app.translator.trans('peopleinside-first-post-approval.admin.settings.first_post_only'),
            },
            help: app.translator.trans('peopleinside-first-post-approval.admin.settings.approval_type_help'),
          });
      }
    }
  ]
};
