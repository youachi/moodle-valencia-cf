<?php
// Construye el curso "Valencia C.F.: Historia, Mestalla y Leyendas" en Moodle 5.2.
define('CLI_SCRIPT', true);
require('/home/claude/src/moodle/config.php');
require_once($CFG->libdir . '/testing/generator/lib.php');
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/mod/quiz/locallib.php');
require_once($CFG->dirroot . '/question/format.php');
require_once($CFG->dirroot . '/question/format/gift/format.php');
require_once($CFG->dirroot . '/grade/grading/lib.php');
require_once($CFG->dirroot . '/grade/grading/form/rubric/tests/generator/rubric.php');
require_once($CFG->dirroot . '/grade/grading/form/rubric/tests/generator/criterion.php');
require_once(__DIR__ . '/contenido.php');

\core\session\manager::set_user(get_admin());
$gen = new testing_data_generator();
$REPO = '/home/claude/moodle-valencia-cf';

// Ajustes del sitio.
set_config('enablecompletion', 1);
set_config('forcelogin', 0);
set_config('guestloginbutton', 1);
set_config('autologinguests', 1);
set_config('defaulthomepage', 0);
set_config('passwordpolicy', 0);

set_config('frontpage', '');
set_config('frontpageloggedin', '5');
set_config('allowframembedding', 1);

// 1. Usuarios.
$sin = fn($s) => preg_replace('/[\x{0300}-\x{036f}]/u', '', Normalizer::normalize($s, Normalizer::FORM_D));
$alumnos = [['kevin', 'Kevin'], ['edgar', 'Edgar'], ['lucia', 'Lucía'], ['alex', 'Álex'],
            ['marcos', 'Marcos'], ['hugo', 'Hugo'], ['roberto', 'Roberto']];
$uid = [];
foreach ($alumnos as [$u, $n]) {
    $uid[$u] = $gen->create_user(['username' => $u, 'password' => $sin($n) . 'VCF1919!', 'firstname' => $n,
        'lastname' => 'Valencianista', 'email' => "$u@vcf-curso.local", 'city' => 'València', 'country' => 'ES'])->id;
}
$prof = $gen->create_user(['username' => 'youssef', 'password' => 'YoussefVCF1919!', 'firstname' => 'Youssef',
    'lastname' => 'Profesor', 'email' => 'youssef@vcf-curso.local', 'city' => 'València', 'country' => 'ES']);

// 2. Curso.
$course = $gen->create_course([
    'fullname' => 'Valencia C.F.: Historia, Mestalla y Leyendas', 'shortname' => 'VCF-1919',
    'format' => 'topics', 'numsections' => 5, 'enablecompletion' => 1, 'showgrades' => 1,
    'summary' => '<p>Curso completo sobre el Valencia Club de Fútbol: historia, Mestalla, leyendas, palmarés y afición. Cinco temas con teoría, vídeos, recursos y diez actividades ordenadas por dificultad.</p>',
    'summaryformat' => FORMAT_HTML,
]);
foreach ($uid as $id) { $gen->enrol_user($id, $course->id, 'student'); }
$gen->enrol_user($prof->id, $course->id, 'editingteacher');

// Acceso de invitados para poder mostrar el curso públicamente.
$enrolplugin = enrol_get_plugin('guest');
$instance = $DB->get_record('enrol', ['courseid' => $course->id, 'enrol' => 'guest']);
if ($instance) { $enrolplugin->update_status($instance, ENROL_INSTANCE_ENABLED); }

$C = ['completion' => COMPLETION_TRACKING_MANUAL];
$sec = fn($n) => $n;

// Sección 0: presentación y evaluación.
course_update_section($course, $DB->get_record('course_sections', ['course' => $course->id, 'section' => 0]),
    ['name' => 'Presentación y evaluación', 'summary' => '<p>Bienvenida al curso. Aquí tienes los avisos, la guía y cómo se evalúa.</p>', 'summaryformat' => FORMAT_HTML]);
$news = $gen->create_module('forum', ['course' => $course->id, 'section' => 0, 'type' => 'news', 'name' => 'Foro de avisos',
    'intro' => '<p>Avisos generales del profesor.</p>']);
$gen->get_plugin_generator('mod_forum')->create_discussion(['course' => $course->id, 'forum' => $news->id, 'userid' => $prof->id,
    'name' => '¡Bienvenidos al curso!', 'message' => '<p>Hola a todos. Empezamos con el Tema 1. Leed la guía del curso y la rúbrica antes de empezar. ¡Amunt!</p>']);
$gen->create_module('page', ['course' => $course->id, 'section' => 0, 'name' => 'Guía del curso', 'content' => $GUIA,
    'intro' => 'Organización, calendario y profesor.'] + $C);
$gen->create_module('page', ['course' => $course->id, 'section' => 0, 'name' => 'Rúbrica y criterios de evaluación',
    'content' => $RUBRICA, 'intro' => 'Cómo se califica cada actividad.'] + $C);

// Helpers.
function vcf_subsection($gen, $course, $section, $name) {
    global $DB;
    $mod = $gen->create_module('subsection', ['course' => $course->id, 'section' => $section, 'name' => $name]);
    return (int)$DB->get_field('course_sections', 'section', ['component' => 'mod_subsection', 'itemid' => $mod->id]);
}
function vcf_import_gift($course, $quiz, $file) {
    global $DB;
    $cm = get_coursemodule_from_instance('quiz', $quiz->id);
    $ctx = context_module::instance($cm->id);
    $cat = question_get_default_category($ctx->id, true);
    $qformat = new qformat_gift();
    $qformat->setCategory($cat);
    $qformat->setContexts([$ctx]);
    $qformat->setCourse($course);
    $qformat->setFilename($file);
    $qformat->setRealfilename(basename($file));
    $qformat->setMatchgrades('error');
    $qformat->setCatfromfile(false);
    $qformat->setContextfromfile(false);
    $qformat->setStoponerror(true);
    $qformat->displayprogress = false;
    ob_start();
    $ok = $qformat->importpreprocess() && $qformat->importprocess() && $qformat->importpostprocess();
    ob_end_clean();
    if (!$ok) { throw new moodle_exception('giftimport', '', '', null, $file); }
    $quizobj = $DB->get_record('quiz', ['id' => $quiz->id]);
    $quizobj->cmid = $cm->id; $quizobj->coursemodule = $cm->id;
    $qids = $DB->get_fieldset_sql("SELECT q.id FROM {question} q
        JOIN {question_versions} qv ON qv.questionid = q.id
        JOIN {question_bank_entries} qbe ON qbe.id = qv.questionbankentryid
        WHERE qbe.questioncategoryid = ? AND q.parent = 0 ORDER BY q.id", [$cat->id]);
    foreach ($qids as $qid) { quiz_add_quiz_question($qid, $quizobj); }
    \mod_quiz\quiz_settings::create($quiz->id)->get_grade_calculator()->recompute_quiz_sumgrades();
    return count($qids);
}
function vcf_rubric($assign) {
    global $DB;
    $cm = get_coursemodule_from_instance('assign', $assign->id);
    $ctx = context_module::instance($cm->id);
    $manager = get_grading_manager($ctx, 'mod_assign', 'submissions');
    $manager->set_active_method('rubric');
    $controller = $manager->get_controller('rubric');
    $r = new \tests\gradingform_rubric\generator\rubric('Rúbrica del curso Valencia C.F.', '5 criterios, hasta 2 puntos cada uno (10 en total).');
    $crit = [
     'Rigor y precisión de los datos' => ['Muchos errores en fechas, nombres o cifras, o información inventada.', 'Datos mayoritariamente correctos, con algún error importante.', 'Datos correctos, con algún fallo menor.', 'Todos los datos (fechas, títulos, cifras) son exactos y están contrastados.'],
     'Profundidad y análisis' => ['Se limita a copiar o enumerar datos, sin explicar nada.', 'Explica los hechos de forma superficial.', 'Relaciona causas y consecuencias con cierta profundidad.', 'Analiza con criterio propio y conecta el tema con la identidad del club.'],
     'Uso y cita de fuentes' => ['No cita ninguna fuente.', 'Cita una sola fuente, o lo hace de forma incompleta.', 'Cita las fuentes pedidas correctamente.', 'Cita más fuentes de las pedidas, fiables y variadas, bien referenciadas.'],
     'Organización y presentación' => ['Desordenado, difícil de leer o con muchas faltas.', 'Estructura básica, con algunas faltas o problemas de formato.', 'Bien estructurado y legible, con pocas faltas.', 'Estructura impecable, visualmente atractiva y sin faltas.'],
     'Creatividad y aportación personal' => ['Sin aportación personal.', 'Aportación personal mínima.', 'Incluye opinión o elementos originales.', 'Propuesta original, con opinión argumentada y recursos propios (imágenes, gráficos, audio...).'],
    ];
    foreach ($crit as $name => $levels) {
        $r->add_criteria(new \tests\gradingform_rubric\generator\criterion($name,
            [$levels[0] => 0, $levels[1] => 1, $levels[2] => 1.5, $levels[3] => 2]));
    }
    $def = $r->get_definition();
    $def->status = gradingform_controller::DEFINITION_STATUS_READY;
    $controller->update_definition($def);
}

// 3. Temas.
$quizfiles = [1 => 'A1-origenes', 2 => 'A3-videos-mestalla', 3 => 'A5-leyendas', 4 => 'A7-palmares', 5 => 'A9-examen-final'];
$quiznames = [1 => 'Actividad 1. Cuestionario: orígenes del club (nivel 1/5)', 2 => 'Actividad 3. Cuestionario sobre los vídeos de Mestalla (nivel 2/5)',
    3 => 'Actividad 5. Cuestionario: leyendas del club (nivel 3/5)', 4 => 'Actividad 7. Cuestionario: palmarés y finales europeas (nivel 4/5)',
    5 => 'Actividad 9. Examen final (nivel 5/5)'];
$total = 0;
foreach ($TEMAS as $n => $t) {
    course_update_section($course, $DB->get_record('course_sections', ['course' => $course->id, 'section' => $n]),
        ['name' => $t['nombre'], 'summary' => $t['resumen'], 'summaryformat' => FORMAT_HTML]);
    $s1 = vcf_subsection($gen, $course, $n, 'Teoría y vídeos');
    $s2 = vcf_subsection($gen, $course, $n, 'Recursos');
    $gen->create_module('page', ['course' => $course->id, 'section' => $s1, 'name' => "Teoría del tema $n", 'content' => $t['teoria'], 'intro' => ''] + $C);
    $vh = '';
    foreach ($t['videos'] as [$id, $tit]) { $vh .= vcf_video($id, $tit); }
    $gen->create_module('page', ['course' => $course->id, 'section' => $s1, 'name' => "Vídeos del tema $n", 'content' => $vh, 'intro' => ''] + $C);
    $gen->create_module('page', ['course' => $course->id, 'section' => $s2, 'name' => 'Enlaces recomendados',
        'content' => '<p>Webs para ampliar el tema:</p>' . vcf_links($t['enlaces']), 'intro' => ''] + $C);
    foreach ($t['urls'] as [$nom, $url]) {
        $gen->create_module('url', ['course' => $course->id, 'section' => $s2, 'name' => $nom, 'externalurl' => $url, 'display' => 6] + $C);
    }

    // Cuestionario del tema.
    $qparams = ['course' => $course->id, 'section' => $n, 'name' => $quiznames[$n], 'grade' => 10, 'questionsperpage' => 1,
        'intro' => '<p>Cuestionario autocorregido del tema ' . $n . '. Repasa la teoría y los vídeos antes de empezar.</p>',
        'completion' => COMPLETION_TRACKING_AUTOMATIC, 'completionview' => 0, 'completionusegrade' => 1];
    if ($n == 5) {
        $qparams['timelimit'] = 20 * 60;
        $qparams['attempts'] = 1;
        $qparams['intro'] = '<p>Examen final con preguntas de todos los temas. <strong>20 minutos y 1 intento.</strong></p>';
    } else {
        $qparams['attempts'] = 0;
    }
    $quiz = $gen->create_module('quiz', $qparams);
    $total += vcf_import_gift($course, $quiz, "$REPO/preguntas-gift/{$quizfiles[$n]}.gift");

    // Segunda actividad del tema.
    if ($n == 1) {
        $forum = $gen->create_module('forum', ['course' => $course->id, 'section' => 1, 'type' => 'general',
            'name' => 'Actividad 2. Foro: ¿por qué soy del Valencia? (nivel 1/5)', 'intro' => $ACT['foro'],
            'grade_forum' => 10, 'completion' => COMPLETION_TRACKING_MANUAL]);
        $fg = $gen->get_plugin_generator('mod_forum');
        $d = $fg->create_discussion(['course' => $course->id, 'forum' => $forum->id, 'userid' => $uid['kevin'],
            'name' => 'Mi primer partido en Mestalla', 'message' => '<p>Soy del Valencia por mi abuelo. Mi primer partido fue contra el Villarreal y no se me olvida cómo sonaba Mestalla.</p>']);
        $fg->create_post(['discussion' => $d->id, 'parent' => $d->firstpost, 'userid' => $uid['lucia'],
            'message' => '<p>¡Qué bonito, Kevin! Dato del tema: el club se fundó el 18 de marzo de 1919 en el Bar Torino.</p>']);
        $fg->create_post(['discussion' => $d->id, 'parent' => $d->firstpost, 'userid' => $uid['hugo'],
            'message' => '<p>Y antes de Mestalla jugaban en el campo de Algirós.</p>']);
    } else if ($n == 2) {
        $glos = $gen->create_module('glossary', ['course' => $course->id, 'section' => 2,
            'name' => 'Actividad 4. Glosario colaborativo: vocabulario valencianista (nivel 2/5)', 'intro' => $ACT['glosario'],
            'mainglossary' => 0, 'defaultapproval' => 1, 'completion' => COMPLETION_TRACKING_MANUAL]);
        $gg = $gen->get_plugin_generator('mod_glossary');
        $autores = array_values($uid);
        foreach ($GLOSARIO as $i => [$c, $d]) {
            $gg->create_content($glos, ['concept' => $c, 'definition' => "<p>$d</p>", 'userid' => $autores[$i % count($autores)], 'approved' => 1]);
        }
    } else {
        $key = [3 => 'tarea6', 4 => 'tarea8', 5 => 'tarea10'][$n];
        $nom = [3 => 'Actividad 6. Tarea: ficha biográfica de una leyenda (nivel 3/5)',
                4 => 'Actividad 8. Tarea: línea del tiempo de los títulos (nivel 4/5)',
                5 => 'Actividad 10. Proyecto final: del Bar Torino al Nou Mestalla (nivel 5/5)'][$n];
        $as = $gen->create_module('assign', ['course' => $course->id, 'section' => $n, 'name' => $nom, 'intro' => $ACT[$key],
            'grade' => 10, 'assignsubmission_file_enabled' => 1, 'assignsubmission_onlinetext_enabled' => 1,
            'assignsubmission_file_maxfiles' => 5, 'assignsubmission_file_maxsizebytes' => 20971520,
            'completion' => COMPLETION_TRACKING_MANUAL]);
        vcf_rubric($as);
    }
}
rebuild_course_cache($course->id, true);
echo "Curso {$course->id} creado. Preguntas: $total\n";
