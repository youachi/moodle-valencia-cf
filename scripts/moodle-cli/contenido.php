<?php
// Contenido del curso "Valencia C.F.: Historia, Mestalla y Leyendas".
// Textos de teoría, recursos y enunciados de actividades.

function vcf_video(string $id, string $titulo): string {
    return '<h4>' . $titulo . '</h4>'
        . '<div class="vcf-video" style="position:relative;padding-bottom:56.25%;height:0;overflow:hidden;max-width:800px;margin-bottom:1.5rem">'
        . '<iframe src="https://www.youtube-nocookie.com/embed/' . $id . '" title="' . s($titulo) . '" '
        . 'style="position:absolute;top:0;left:0;width:100%;height:100%;border:0" '
        . 'allow="accelerometer; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>'
        . '<p><a href="https://www.youtube.com/watch?v=' . $id . '" target="_blank">Ver en YouTube</a></p>';
}

function vcf_links(array $links): string {
    $h = '<ul>';
    foreach ($links as [$url, $texto, $nota]) {
        $h .= '<li><a href="' . $url . '" target="_blank">' . $texto . '</a>: ' . $nota . '</li>';
    }
    return $h . '</ul>';
}

$GUIA = <<<HTML
<h3>Bienvenida</h3>
<p>Este curso recorre más de cien años de historia del <strong>Valencia Club de Fútbol</strong>: desde su fundación en el Bar Torino en 1919 hasta el Nou Mestalla. Está pensado para trabajarse en cinco semanas, un tema por semana.</p>
<h3>Cómo está organizado</h3>
<p>Cada tema tiene dos bloques:</p>
<ul>
<li><strong>Teoría y vídeos:</strong> una página con los contenidos del tema y otra con vídeos seleccionados.</li>
<li><strong>Recursos:</strong> enlaces recomendados para ampliar y dos recursos web.</li>
</ul>
<p>Después de los bloques encontrarás dos actividades. Están ordenadas de menor a mayor dificultad (de 1/5 a 5/5).</p>
<h3>Calendario orientativo</h3>
<table class="table table-striped">
<thead><tr><th>Semana</th><th>Tema</th><th>Actividades</th></tr></thead>
<tbody>
<tr><td>1</td><td>Historia del club (1919-actualidad)</td><td>Act. 1 y 2</td></tr>
<tr><td>2</td><td>Mestalla, el estadio del club</td><td>Act. 3 y 4</td></tr>
<tr><td>3</td><td>Jugadores y entrenadores históricos</td><td>Act. 5 y 6</td></tr>
<tr><td>4</td><td>Palmarés y finales europeas</td><td>Act. 7 y 8</td></tr>
<tr><td>5</td><td>Afición, símbolos y cultura</td><td>Act. 9 y 10</td></tr>
</tbody></table>
<h3>Profesor</h3>
<p>Youssef. Las dudas se plantean en el foro de avisos o por mensaje privado.</p>
HTML;

$RUBRICA = <<<HTML
<p>Las tareas <strong>6, 8 y 10</strong> se califican con esta rúbrica. Hay 5 criterios y cada uno vale hasta 2 puntos (10 puntos en total).</p>
<table class="table table-bordered">
<thead><tr><th>Criterio</th><th>Insuficiente (0)</th><th>Suficiente (1)</th><th>Notable (1,5)</th><th>Excelente (2)</th></tr></thead>
<tbody>
<tr><th>Rigor y precisión de los datos</th><td>Muchos errores en fechas, nombres o cifras, o información inventada.</td><td>Datos mayoritariamente correctos, con algún error importante.</td><td>Datos correctos, con algún fallo menor.</td><td>Todos los datos (fechas, títulos, cifras) son exactos y están contrastados.</td></tr>
<tr><th>Profundidad y análisis</th><td>Se limita a copiar o enumerar datos, sin explicar nada.</td><td>Explica los hechos de forma superficial.</td><td>Relaciona causas y consecuencias con cierta profundidad.</td><td>Analiza con criterio propio y conecta el tema con la identidad del club.</td></tr>
<tr><th>Uso y cita de fuentes</th><td>No cita ninguna fuente.</td><td>Cita una sola fuente, o lo hace de forma incompleta.</td><td>Cita las fuentes pedidas correctamente.</td><td>Cita más fuentes de las pedidas, fiables y variadas, bien referenciadas.</td></tr>
<tr><th>Organización y presentación</th><td>Desordenado, difícil de leer o con muchas faltas.</td><td>Estructura básica, con algunas faltas o problemas de formato.</td><td>Bien estructurado y legible, con pocas faltas.</td><td>Estructura impecable, visualmente atractiva y sin faltas.</td></tr>
<tr><th>Creatividad y aportación personal</th><td>Sin aportación personal.</td><td>Aportación personal mínima.</td><td>Incluye opinión o elementos originales.</td><td>Propuesta original, con opinión argumentada y recursos propios (imágenes, gráficos, audio...).</td></tr>
</tbody></table>
<h3>Criterios del foro (Actividad 2), sobre 10</h3>
<ul><li>Mensaje propio con un recuerdo o motivo personal: 4</li><li>Al menos 2 respuestas a compañeros que aporten un dato del tema: 4</li><li>Corrección, respeto y buena ortografía: 2</li></ul>
<h3>Peso de cada actividad</h3>
<table class="table table-striped">
<thead><tr><th>#</th><th>Actividad</th><th>Tipo</th><th>Nivel</th><th>Peso</th></tr></thead>
<tbody>
<tr><td>1</td><td>Cuestionario: orígenes del club</td><td>Cuestionario</td><td>1/5</td><td>5 %</td></tr>
<tr><td>2</td><td>Foro: ¿por qué soy del Valencia?</td><td>Foro calificado</td><td>1/5</td><td>5 %</td></tr>
<tr><td>3</td><td>Cuestionario sobre los vídeos de Mestalla</td><td>Cuestionario</td><td>2/5</td><td>10 %</td></tr>
<tr><td>4</td><td>Glosario colaborativo: vocabulario valencianista</td><td>Glosario</td><td>2/5</td><td>No calificable</td></tr>
<tr><td>5</td><td>Cuestionario: leyendas del club</td><td>Cuestionario</td><td>3/5</td><td>10 %</td></tr>
<tr><td>6</td><td>Tarea: ficha biográfica de una leyenda</td><td>Tarea con rúbrica</td><td>3/5</td><td>15 %</td></tr>
<tr><td>7</td><td>Cuestionario: palmarés y finales europeas</td><td>Cuestionario</td><td>4/5</td><td>10 %</td></tr>
<tr><td>8</td><td>Tarea: línea del tiempo de los títulos</td><td>Tarea con rúbrica</td><td>4/5</td><td>15 %</td></tr>
<tr><td>9</td><td>Examen final (20 min, 1 intento)</td><td>Cuestionario</td><td>5/5</td><td>10 %</td></tr>
<tr><td>10</td><td>Proyecto final: del Bar Torino al Nou Mestalla</td><td>Tarea con rúbrica</td><td>5/5</td><td>20 %</td></tr>
</tbody></table>
HTML;

$TEMAS = [
1 => [
 'nombre' => 'Tema 1. Historia del club (1919-actualidad)',
 'resumen' => '<p>De una tertulia en el Bar Torino a uno de los grandes clubes de Europa.</p>',
 'teoria' => <<<HTML
<h3>1. La fundación (1919)</h3>
<p>El Valencia Club de Fútbol nació el <strong>18 de marzo de 1919</strong>. La idea surgió en una tertulia de aficionados en el <strong>Bar Torino</strong>, en el centro de Valencia. Según la tradición, el primer presidente, <strong>Octavio Augusto Milego</strong>, fue elegido lanzando una moneda al aire.</p>
<p>El club jugó sus primeros partidos en el <strong>campo de Algirós</strong>. En 1923 se trasladó a Mestalla, su casa desde entonces.</p>
<h3>2. Los primeros éxitos y la «delantera eléctrica» (años 40)</h3>
<p>En los años 40 el Valencia se convirtió en un equipo grande gracias a la <strong>delantera eléctrica</strong>: Epi, Amadeo, Mundo, Asensi y Gorostiza. Con ellos llegaron la primera Copa (1941) y las Ligas de <strong>1942, 1944 y 1947</strong>.</p>
<h3>3. Europa y la Copa de Ferias (años 60)</h3>
<p>El club ganó dos <strong>Copas de Ferias</strong> seguidas, en 1962 y 1963, y la Copa de 1967.</p>
<h3>4. Di Stéfano, Kempes y la Recopa (1970-1980)</h3>
<p>Con Alfredo di Stéfano en el banquillo llegó la Liga de <strong>1971</strong>. A finales de los 70, Mario Alberto Kempes lideró al equipo que ganó la Copa de 1979, la <strong>Recopa de 1980</strong> ante el Arsenal (en los penaltis) y la Supercopa de Europa de 1980.</p>
<h3>5. El descenso y la vuelta (1986-1987)</h3>
<p>En <strong>1986</strong> el Valencia descendió a Segunda División por primera y única vez. Volvió a Primera solo un año después.</p>
<h3>6. La edad de oro (1999-2004)</h3>
<p>Copa del Rey y Supercopa de España en 1999, dos finales de Champions seguidas (2000 y 2001) con Héctor Cúper y, con Rafa Benítez, las Ligas de <strong>2002 y 2004</strong> y la <strong>Copa de la UEFA de 2004</strong>.</p>
<h3>7. El Centenario (2019) y la actualidad</h3>
<p>En el año del Centenario el equipo de Marcelino ganó la <strong>Copa del Rey de 2019</strong>. Hoy el gran reto es terminar el <strong>Nou Mestalla</strong>, cuyas obras se reanudaron en 2025.</p>
<div class="alert alert-info">Para repasar: fecha de fundación, Bar Torino, Algirós, delantera eléctrica, descenso de 1986.</div>
HTML,
 'videos' => [['FwppmBF6skI', 'Valencia CF: historia completa'], ['7ETuy8_4lcw', '90 anys d\'història']],
 'enlaces' => [
   ['https://es.wikipedia.org/wiki/Valencia_Club_de_F%C3%BAtbol', 'Wikipedia: Valencia C.F.', 'resumen general de la historia del club.'],
   ['https://es.wikipedia.org/wiki/Historia_del_Valencia_Club_de_F%C3%BAtbol', 'Wikipedia: Historia del Valencia C.F.', 'la historia completa, década a década.'],
   ['https://www.valenciacf.com', 'Web oficial del Valencia C.F.', 'noticias y sección de historia del club.'],
 ],
 'urls' => [
   ['Historia del Valencia C.F. (Wikipedia)', 'https://es.wikipedia.org/wiki/Historia_del_Valencia_Club_de_F%C3%BAtbol'],
   ['Web oficial del club', 'https://www.valenciacf.com'],
 ],
],
2 => [
 'nombre' => 'Tema 2. Mestalla, el estadio del club',
 'resumen' => '<p>El estadio en activo más antiguo de la Primera División y una de las gradas más empinadas del mundo.</p>',
 'teoria' => <<<HTML
<h3>1. Inauguración</h3>
<p>Mestalla se inauguró el <strong>20 de mayo de 1923</strong> con un partido contra el <strong>Levante</strong>. Su nombre viene de la <strong>acequia de Mestalla</strong>, una de las acequias de riego de la huerta valenciana que pasaba junto al campo.</p>
<h3>2. Crecimiento y reconstrucción</h3>
<p>El estadio fue ampliándose con los años. Durante la Guerra Civil sufrió daños y tuvo que reconstruirse. En 1957 una riada del Turia lo inundó.</p>
<h3>3. Estadio Luis Casanova (1969-1994)</h3>
<p>Entre 1969 y 1994 se llamó <strong>Estadio Luis Casanova</strong>, en honor a uno de los presidentes del club. En 1994 recuperó el nombre de Mestalla.</p>
<h3>4. Mestalla, sede mundialista</h3>
<p>Mestalla fue sede del <strong>Mundial de España 1982</strong>. También ha acogido finales de Copa y partidos de la selección.</p>
<h3>5. Cómo es Mestalla</h3>
<ul>
<li>Capacidad aproximada de 49 000 espectadores.</li>
<li>Su <strong>grada de tribuna</strong> es famosa por ser una de las más empinadas de Europa: el público está muy cerca del césped.</li>
<li>La <strong>Curva Nord</strong> es el corazón de la animación.</li>
</ul>
<h3>6. El Nou Mestalla</h3>
<p>Las obras del nuevo estadio empezaron en 2007 y se pararon en <strong>2009</strong> por la crisis económica. Se reanudaron en <strong>enero de 2025</strong>.</p>
HTML,
 'videos' => [['g0Qyz7wy9fI', 'Historia, pasión, leyenda: 100 años'], ['_6x7C3YQcHk', 'Mestalla: 100 años de historia']],
 'enlaces' => [
   ['https://es.wikipedia.org/wiki/Estadio_de_Mestalla', 'Wikipedia: Estadio de Mestalla', 'historia, reformas y datos del estadio.'],
   ['https://es.wikipedia.org/wiki/Nou_Mestalla', 'Wikipedia: Nou Mestalla', 'el proyecto del nuevo estadio.'],
   ['https://es.wikipedia.org/wiki/Copa_Mundial_de_F%C3%BAtbol_de_1982', 'Wikipedia: Mundial de 1982', 'el Mundial en el que Mestalla fue sede.'],
 ],
 'urls' => [
   ['Estadio de Mestalla (Wikipedia)', 'https://es.wikipedia.org/wiki/Estadio_de_Mestalla'],
   ['Mestalla en Google Maps', 'https://www.google.com/maps/search/Estadio+de+Mestalla+Valencia'],
 ],
],
3 => [
 'nombre' => 'Tema 3. Jugadores y entrenadores históricos',
 'resumen' => '<p>Mundo, Puchades, Kempes, Fernando, Albelda, Cañizares, Gayà... y los entrenadores que hicieron campeón al Valencia.</p>',
 'teoria' => <<<HTML
<h3>1. Los goleadores</h3>
<ul>
<li><strong>Edmundo Suárez «Mundo»</strong> (años 40): máximo goleador histórico del club y pieza clave de la delantera eléctrica.</li>
<li><strong>Mario Alberto Kempes, «El Matador»</strong>: Pichichi en 1977 y 1978 y campeón del mundo con <strong>Argentina en 1978</strong> siendo jugador del Valencia.</li>
<li><strong>David Villa</strong>: uno de los grandes delanteros del club en los años 2000.</li>
</ul>
<h3>2. Los capitanes y los fieles</h3>
<ul>
<li><strong>Antonio Puchades</strong>: gran capitán de los años 50.</li>
<li><strong>Fernando Gómez Colomer</strong>: récord de partidos oficiales con el club (<strong>552</strong>).</li>
<li><strong>Ricardo Arias</strong> y <strong>Enrique Saura</strong>: históricos de los 70 y 80.</li>
<li><strong>José Luis Gayà</strong>: capitán actual; alcanzó los 400 partidos oficiales e igualó a Enrique Saura.</li>
</ul>
<h3>3. El equipo de las Ligas de 2002 y 2004</h3>
<p>Cañizares en la portería, Ayala en defensa, el doble pivote <strong>Albelda-Baraja</strong>, Vicente, Mista, Aimar... <strong>Roberto Ayala</strong> fue elegido mejor jugador de la final de la UEFA de Gotemburgo 2004.</p>
<h3>4. Los entrenadores campeones</h3>
<table class="table table-striped">
<thead><tr><th>Entrenador</th><th>Logro</th></tr></thead>
<tbody>
<tr><td>Alfredo di Stéfano</td><td>Liga 1971 y Recopa 1980</td></tr>
<tr><td>Héctor Cúper</td><td>Finales de Champions 2000 y 2001</td></tr>
<tr><td>Rafa Benítez</td><td>Ligas 2002 y 2004, Copa de la UEFA 2004</td></tr>
<tr><td>Marcelino García Toral</td><td>Copa del Rey 2019 (Centenario)</td></tr>
</tbody></table>
HTML,
 'videos' => [['_H_aCgeOm5o', 'Los mejores momentos de Kempes']],
 'enlaces' => [
   ['https://es.wikipedia.org/wiki/Mario_Alberto_Kempes', 'Wikipedia: Mario Alberto Kempes', 'biografía de «El Matador».'],
   ['https://es.wikipedia.org/wiki/Edmundo_Su%C3%A1rez', 'Wikipedia: Edmundo Suárez «Mundo»', 'el máximo goleador de la historia del club.'],
   ['https://es.wikipedia.org/wiki/Anexo:Futbolistas_del_Valencia_Club_de_F%C3%BAtbol', 'Wikipedia: futbolistas del Valencia C.F.', 'lista completa de jugadores.'],
 ],
 'urls' => [
   ['Mario Alberto Kempes (Wikipedia)', 'https://es.wikipedia.org/wiki/Mario_Alberto_Kempes'],
   ['Entrenadores del Valencia C.F. (Wikipedia)', 'https://es.wikipedia.org/wiki/Anexo:Entrenadores_del_Valencia_Club_de_F%C3%BAtbol'],
 ],
],
4 => [
 'nombre' => 'Tema 4. Palmarés y finales europeas',
 'resumen' => '<p>6 Ligas, 8 Copas del Rey, Copa de la UEFA, Recopa, Copas de Ferias... y dos finales de Champions.</p>',
 'teoria' => <<<HTML
<h3>1. Títulos nacionales</h3>
<table class="table table-striped">
<thead><tr><th>Título</th><th>Nº</th><th>Años</th></tr></thead>
<tbody>
<tr><td>Liga</td><td>6</td><td>1942, 1944, 1947, 1971, 2002, 2004</td></tr>
<tr><td>Copa del Rey</td><td>8</td><td>1941, 1949, 1954, 1967, 1979, 1999, 2008, 2019</td></tr>
<tr><td>Supercopa de España</td><td>1</td><td>1999</td></tr>
</tbody></table>
<h3>2. Títulos europeos</h3>
<table class="table table-striped">
<thead><tr><th>Título</th><th>Años</th><th>Detalle</th></tr></thead>
<tbody>
<tr><td>Copa de Ferias</td><td>1962, 1963</td><td>Dos seguidas</td></tr>
<tr><td>Recopa de Europa</td><td>1980</td><td>Final contra el Arsenal, ganada en los penaltis</td></tr>
<tr><td>Supercopa de Europa</td><td>1980, 2004</td><td></td></tr>
<tr><td>Copa de la UEFA</td><td>2004</td><td>Final en <strong>Gotemburgo</strong>: Valencia 2-0 Olympique de Marsella (goles de <strong>Vicente y Mista</strong>)</td></tr>
</tbody></table>
<h3>3. Las finales de Champions</h3>
<ul>
<li><strong>2000 (París):</strong> Real Madrid 3-0 Valencia.</li>
<li><strong>2001 (Milán):</strong> Bayern de Múnich - Valencia, 1-1 y derrota en los penaltis.</li>
</ul>
<p>Las dos con <strong>Héctor Cúper</strong> en el banquillo.</p>
<h3>4. La Copa del Centenario (2019)</h3>
<p>El 25 de mayo de 2019, en el estadio Benito Villamarín de Sevilla, el Valencia ganó la final al <strong>FC Barcelona por 1-2</strong>, con goles de Gameiro y Rodrigo.</p>
HTML,
 'videos' => [['bqH6wb7acoQ', 'El año del doblete 2003-04'], ['mQyhS4n9dbc', 'Resumen de la final de Copa 2019']],
 'enlaces' => [
   ['https://es.wikipedia.org/wiki/Final_de_la_Copa_de_la_UEFA_2003-04', 'Wikipedia: Final de la Copa de la UEFA 2004', 'la final de Gotemburgo.'],
   ['https://es.wikipedia.org/wiki/Final_de_la_Copa_del_Rey_2019', 'Wikipedia: Final de la Copa del Rey 2019', 'la Copa del Centenario.'],
   ['https://es.wikipedia.org/wiki/Valencia_Club_de_F%C3%BAtbol#Palmar%C3%A9s', 'Wikipedia: palmarés del Valencia', 'lista completa de títulos.'],
 ],
 'urls' => [
   ['Final de la Copa de la UEFA 2004 (Wikipedia)', 'https://es.wikipedia.org/wiki/Final_de_la_Copa_de_la_UEFA_2003-04'],
   ['Final de la Copa del Rey 2019 (Wikipedia)', 'https://es.wikipedia.org/wiki/Final_de_la_Copa_del_Rey_2019'],
 ],
],
5 => [
 'nombre' => 'Tema 5. Afición, símbolos y cultura',
 'resumen' => '<p>El murciélago, los «ches», el himno, el derbi y una afición que llena Mestalla desde hace más de cien años.</p>',
 'teoria' => <<<HTML
<h3>1. El escudo y el murciélago</h3>
<p>El escudo del Valencia lleva un <strong>murciélago</strong> («rat penat» en valenciano), símbolo heredado del escudo de la ciudad y relacionado con la tradición del rey Jaime I.</p>
<h3>2. Colores y apodos</h3>
<ul>
<li>Colores: <strong>blanco y negro</strong> (el equipo es «el blanquinegro»).</li>
<li>Apodo: <strong>«los ches»</strong>, por la interjección «che», muy típica del habla valenciana.</li>
<li>Grito de ánimo: <strong>«Amunt Valencia!»</strong></li>
</ul>
<h3>3. Himnos</h3>
<p>El himno del Centenario, <strong>«Eterno junto a ti»</strong>, lo compuso e interpretó el grupo valenciano <strong>Bombai</strong>.</p>
<h3>4. La afición</h3>
<p>En Mestalla hay una estatua de <strong>Vicent Navarro</strong>, el aficionado ciego con el carné de socio número 18, que siguió yendo al estadio durante décadas. Es un símbolo de la fidelidad valencianista.</p>
<h3>5. Rivalidades</h3>
<ul>
<li>Con el <strong>Levante</strong>: el derbi de la ciudad.</li>
<li>Con el <strong>Villarreal</strong>: el «derbi de la Comunitat».</li>
</ul>
HTML,
 'videos' => [['dXMUXKYkiLE', 'Mestalla y afición'], ['-ypaTzGc4ww', 'Recibimiento en Mestalla']],
 'enlaces' => [
   ['https://es.wikipedia.org/wiki/Rat_penat', 'Wikipedia: Rat penat', 'origen del murciélago en los símbolos valencianos.'],
   ['https://es.wikipedia.org/wiki/Derbi_de_la_Comunidad_Valenciana', 'Wikipedia: Derbi de la Comunitat', 'la rivalidad con el Villarreal.'],
   ['https://es.wikipedia.org/wiki/Bombai', 'Wikipedia: Bombai', 'el grupo autor del himno del Centenario.'],
 ],
 'urls' => [
   ['Escudo del Valencia C.F. (Wikipedia)', 'https://es.wikipedia.org/wiki/Valencia_Club_de_F%C3%BAtbol#Escudo'],
   ['Web oficial del Valencia C.F.', 'https://www.valenciacf.com'],
 ],
],
];

$ACT = [
 'foro' => '<p><strong>Nivel 1/5.</strong> Cuéntanos <strong>por qué eres del Valencia</strong> (o por qué te interesa el club): un partido que recuerdes, un jugador, alguien de tu familia...</p><ul><li>Publica un mensaje propio.</li><li>Responde al menos a <strong>2 compañeros</strong> aportando un dato del Tema 1.</li></ul><p>Se califica sobre 10 (ver criterios en la rúbrica del curso).</p>',
 'glosario' => '<p><strong>Nivel 2/5.</strong> Entre todos construimos el vocabulario valencianista. Cada alumno añade <strong>al menos 2 términos</strong> que no estén ya en el glosario, con su definición y, si puede, una imagen o un enlace.</p>',
 'tarea6' => '<p><strong>Nivel 3/5.</strong> Elabora la <strong>ficha biográfica de una leyenda</strong> del Valencia (jugador o entrenador) que <em>no</em> sea Kempes.</p><ul><li>Datos personales y trayectoria.</li><li>Etapa en el Valencia: años, partidos, goles y títulos.</li><li>Por qué es una leyenda para la afición.</li><li>Cita al menos <strong>2 fuentes</strong>.</li></ul><p>Entrega: PDF de 1-2 páginas. Se califica con la rúbrica del curso.</p>',
 'tarea8' => '<p><strong>Nivel 4/5.</strong> Construye una <strong>línea del tiempo con todos los títulos oficiales</strong> del Valencia (Ligas, Copas, Supercopas y títulos europeos).</p><ul><li>Marca con un color distinto los títulos nacionales y los europeos.</li><li>Añade las dos finales de Champions perdidas.</li><li>Puedes usar Canva, Genially, PowerPoint o papel escaneado.</li><li>Cita al menos <strong>2 fuentes</strong>.</li></ul><p>Se califica con la rúbrica del curso.</p>',
 'tarea10' => '<p><strong>Nivel 5/5.</strong> Proyecto final: <strong>«Del Bar Torino al Nou Mestalla»</strong>.</p><p>Crea una presentación o un vídeo (máximo 5 minutos) que cuente la historia del club uniendo los cinco temas del curso: fundación, estadio, leyendas, títulos y afición.</p><ul><li>Incluye tu opinión sobre el futuro del club y el Nou Mestalla.</li><li>Usa recursos propios (imágenes, gráficos, audio).</li><li>Cita al menos <strong>3 fuentes</strong>.</li></ul><p>Se califica con la rúbrica del curso.</p>',
];

$GLOSARIO = [
 ['Ches', 'Apodo de los jugadores y aficionados del Valencia, por la interjección «che», típica del habla valenciana.'],
 ['Rat penat', 'Murciélago en valenciano. Es el animal que aparece en el escudo del club.'],
 ['Amunt', '«¡Arriba!» en valenciano. El grito de ánimo de la afición: «Amunt Valencia!».'],
 ['Delantera eléctrica', 'Línea de ataque de los años 40 formada por Epi, Amadeo, Mundo, Asensi y Gorostiza.'],
 ['Mestalla', 'Estadio del Valencia desde 1923. Debe su nombre a la acequia de Mestalla.'],
 ['Blanquinegro', 'Forma de llamar al Valencia por los colores de su equipación: blanco y negro.'],
];
