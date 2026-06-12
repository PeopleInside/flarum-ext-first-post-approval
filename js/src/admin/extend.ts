import app from 'flarum/admin/app';

// Questa riga è fondamentale: esporta gli extender dichiarativi
export { default as extend } from './extend';

app.initializers.add('peopleinside-first-post-approval', () => {
  // Eventuali altre logiche imperative vanno qui.
  // Le impostazioni e i permessi sono ora gestiti in extend.ts
});
