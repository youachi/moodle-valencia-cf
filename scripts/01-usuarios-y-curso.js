/**
 * 01-usuarios-y-curso.js
 * Requiere haber ejecutado antes scripts/moodle-helpers.js en la consola.
 * Crea los usuarios, el curso con 5 temas y matricula a todos.
 */
(async () => {
  const usuarios = [
    ['kevin', 'Kevin'], ['edgar', 'Edgar'], ['lucia', 'Lucía'], ['alex', 'Álex'],
    ['marcos', 'Marcos'], ['hugo', 'Hugo'], ['roberto', 'Roberto']
  ];
  const sinTildes = s => s.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

  // 1. Alumnos: contraseña = nombre sin tildes + VCF1919!  (p. ej. KevinVCF1919!)
  for (const [u, n] of usuarios) {
    await mf.submit('/user/editadvanced.php?id=-1', {
      username: u, auth: 'manual', newpassword: sinTildes(n) + 'VCF1919!',
      firstname: n, lastname: 'Valencianista', email: u + '@vcf-curso.local',
      city: 'València', country: 'ES', preference_auth_forcepasswordchange: '0',
      submitbutton: 'Crear usuario'
    });
  }
  // 2. Profesor
  await mf.submit('/user/editadvanced.php?id=-1', {
    username: 'youssef', auth: 'manual', newpassword: 'YoussefVCF1919!',
    firstname: 'Youssef', lastname: 'Profesor', email: 'youssef@vcf-curso.local',
    city: 'València', country: 'ES', preference_auth_forcepasswordchange: '0', submitbutton: 'Crear usuario'
  });

  // 3. Curso (formato por temas, 5 secciones, finalización activada)
  await mf.submit('/course/edit.php?category=1', {
    fullname: 'Valencia C.F.: Historia, Mestalla y Leyendas', shortname: 'VCF-1919',
    format: 'topics', numsections: '5', enablecompletion: '1', showgrades: '1',
    saveanddisplay: 'Guardar y mostrar'
  }, { remove: ['saveandreturn', 'cancel'] });

  // 4. Matriculación (identificadores tomados de la página de matriculación manual)
  //    En esta instalación: alumnos 3-9, profesor 10, enrolid 1.
  await mf.enrol(1, ['3', '4', '5', '6', '7', '8', '9'], '5'); // Estudiantes
  await mf.enrol(1, ['10'], '3');                              // Profesor
  console.log('Usuarios, curso y matriculación creados');
})();
