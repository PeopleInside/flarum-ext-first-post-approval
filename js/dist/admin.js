flarum.extensions['peopleinside-first-post-approval'] = function() {
  const app = flarum.core.app;
  app.initializers.add('peopleinside-first-post-approval', function() {
    app.extensionData
      .for('peopleinside-first-post-approval')
      .registerSetting({
        setting: 'peopleinside-first-post-approval.approval_type',
        label: app.translator.trans('peopleinside-first-post-approval.admin.settings.approval_type_label'),
        type: 'select',
        options: {
          'all': app.translator.trans('peopleinside-first-post-approval.admin.settings.all_posts'),
          'first': app.translator.trans('peopleinside-first-post-approval.admin.settings.first_post_only'),
        }
      });
  });
};
