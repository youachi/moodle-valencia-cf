/**
 * moodle-helpers.js
 * Funciones auxiliares para automatizar Moodle 5.x desde la consola del navegador
 * (F12 > Consola) con sesión iniciada como administrador en http://localhost:8080
 *
 * Se utilizaron para crear el curso "Valencia C.F.: Historia, Mestalla y Leyendas".
 * Rellenan los formularios oficiales de Moodle (los mismos campos que la interfaz),
 * por lo que respetan permisos, sesskey y validaciones.
 */
window.mf = {
  // Descarga una página de Moodle y la convierte en DOM
  async get(url) {
    const r = await fetch(url, { credentials: 'include' });
    const t = await r.text();
    return { url: r.url, doc: new DOMParser().parseFromString(t, 'text/html'), text: t };
  },

  // Devuelve los mensajes de error de validación de un formulario
  errs(doc) {
    return [...doc.querySelectorAll('.invalid-feedback, .error, .alert-danger, .errorbox')]
      .map(e => e.innerText.trim()).filter(Boolean).join(' / ').slice(0, 400);
  },

  // Elige el formulario principal (mform) de la página
  pick(doc, sel) {
    if (sel) return doc.querySelector(sel);
    return [...doc.querySelectorAll('form.mform')].filter(f => !f.classList.contains('simplesearchform'))[0];
  },

  // Abre un formulario, cambia los campos indicados y lo envía
  // overrides: { campo: valor }  (null = eliminar el campo, array = varios valores)
  async submit(url, overrides = {}, opts = {}) {
    const g = await this.get(url);
    const f = this.pick(g.doc, opts.formSel);
    if (!f) return { ok: false, msg: 'noform ' + g.url, err: this.errs(g.doc) };
    const fd = new FormData(f);
    for (const rm of (opts.remove || [])) fd.delete(rm);
    for (const [k, v] of Object.entries(overrides)) {
      if (Array.isArray(v)) { fd.delete(k); v.forEach(x => fd.append(k, x)); }
      else if (v === null) fd.delete(k);
      else fd.set(k, v);
    }
    const action = new URL(f.getAttribute('action') || url, g.url).href;
    const r = await fetch(action, { method: 'POST', body: fd, credentials: 'include' });
    const t = await r.text();
    const d = new DOMParser().parseFromString(t, 'text/html');
    return { ok: true, url: r.url, title: d.title, err: this.errs(d), doc: d, text: t };
  },

  // Crea una actividad o recurso (page, url, quiz, assign, forum, glossary, subsection...)
  async addMod(mod, section, fields, courseid = 2) {
    const r = await this.submit(
      `/course/modedit.php?add=${mod}&course=${courseid}&section=${section}&return=0`,
      Object.assign({ submitbutton2: 'Guardar cambios y regresar al curso' }, fields),
      { remove: ['cancel', 'submitbutton'] });
    return mod + '@' + section + ': ' + (r.err ? 'ERR ' + r.err : 'OK');
  },

  // Sube un texto en formato GIFT al banco de preguntas de un cuestionario (cmid)
  async importGift(cmid, gift) {
    const g = await this.get('/question/bank/importquestions/import.php?cmid=' + cmid);
    const f = this.pick(g.doc);
    const itemid = f.querySelector('[name=newfile]').value;
    const repo = (g.text.match(/"id":"?(\d+)"?,[^{}]*?"type":"upload"/) ||
                  g.text.match(/"type":"upload"[^{}]*?"id":"?(\d+)"?/) || [])[1];
    const ctx = (g.text.match(/"contextid":(\d+)/) || [])[1];
    const up = new FormData();
    up.append('repo_upload_file', new File([gift], 'preguntas.txt', { type: 'text/plain' }));
    up.append('sesskey', M.cfg.sesskey); up.append('repo_id', repo); up.append('itemid', itemid);
    up.append('title', 'preguntas.txt'); up.append('savepath', '/'); up.append('ctx_id', ctx);
    up.append('author', 'Youssef'); up.append('license', 'unknown'); up.append('env', 'filepicker');
    await fetch('/repository/repository_ajax.php?action=upload', { method: 'POST', body: up, credentials: 'include' });
    const fd = new FormData(f); fd.set('format', 'gift'); fd.set('submitbutton', 'Importar');
    const r = await fetch(new URL(f.getAttribute('action'), g.url).href, { method: 'POST', body: fd, credentials: 'include' });
    const txt = (new DOMParser().parseFromString(await r.text(), 'text/html').querySelector('[role=main]') || {}).innerText || '';
    return (txt.match(/Importando (\d+)/) || [])[0];
  },

  // Añade al cuestionario todas las preguntas de su banco
  async addAllToQuiz(cmid) {
    const g = await this.get('/question/edit.php?cmid=' + cmid);
    const ids = [...new Set([...g.doc.querySelectorAll('input[name^=q]')].map(i => i.name).filter(n => /^q\d+$/.test(n)))];
    const fd = new FormData();
    fd.append('sesskey', M.cfg.sesskey); fd.append('cmid', cmid); fd.append('add', '1'); fd.append('addonpage', '0');
    ids.forEach(n => fd.append(n, '1'));
    await fetch('/mod/quiz/edit.php?cmid=' + cmid, { method: 'POST', body: fd, credentials: 'include' });
    return ids.length;
  },

  // Define una rúbrica en el área de calificación avanzada de una tarea
  // criteria: [[nombre, [descInsuficiente, descSuficiente, descNotable, descExcelente]], ...]
  async saveRubric(areaid, name, description, criteria,
                   levels = [['Insuficiente', 0], ['Suficiente', 1], ['Notable', 1.5], ['Excelente', 2]]) {
    const g = await this.get('/grade/grading/form/rubric/edit.php?areaid=' + areaid);
    const f = this.pick(g.doc); const fd = new FormData(f);
    [...fd.keys()].filter(k => k.startsWith('rubric[criteria]')).forEach(k => fd.delete(k));
    fd.set('name', name); fd.set('description_editor[text]', description);
    criteria.forEach((c, i) => {
      const p = 'rubric[criteria][NEWID' + (i + 1) + ']';
      fd.append(p + '[sortorder]', i + 1); fd.append(p + '[description]', c[0]);
      levels.forEach((l, j) => {
        fd.append(p + '[levels][NEWID' + j + '][definition]', l[0] + ': ' + c[1][j]);
        fd.append(p + '[levels][NEWID' + j + '][score]', l[1]);
      });
    });
    fd.set('saverubric', 'Guardar rúbrica y dejarla preparada');
    const r = await fetch(new URL(f.getAttribute('action'), g.url).href, { method: 'POST', body: fd, credentials: 'include' });
    return r.ok;
  },

  // Matricula usuarios (ids) con un rol (5 = estudiante, 3 = profesor) en la matriculación manual
  async enrol(enrolid, ids, roleid) {
    const g = await this.get('/enrol/manual/manage.php?enrolid=' + enrolid);
    const f = g.doc.querySelector('#assignform'); const fd = new FormData(f);
    fd.delete('addselect[]'); fd.delete('removeselect[]'); fd.delete('remove');
    ids.forEach(i => fd.append('addselect[]', i));
    fd.set('roleid', roleid); fd.set('add', 'Agregar');
    return (await fetch('/enrol/manual/manage.php?enrolid=' + enrolid, { method: 'POST', body: fd, credentials: 'include' })).status;
  }
};
