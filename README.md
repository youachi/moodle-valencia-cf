# Moodle: Valencia C.F., Historia, Mestalla y Leyendas

Práctica de Moodle 5.2 instalado en una máquina virtual (`http://localhost:8080`).
Curso completo sobre el Valencia Club de Fútbol con cinco temas: teoría, vídeos, recursos,
diez actividades ordenadas por dificultad y una rúbrica de evaluación.

- **Profesor:** Youssef
- **Alumnado:** Kevin, Edgar, Lucía, Álex, Marcos, Hugo y Roberto

## Estructura del curso

| Sección | Contenido |
|---|---|
| Presentación y evaluación | Foro de avisos, guía del curso, rúbrica y criterios de evaluación |
| Tema 1. Historia del club (1919-actualidad) | Teoría y vídeos, recursos, Act. 1 (cuestionario), Act. 2 (foro) |
| Tema 2. Mestalla, el estadio del club | Teoría y vídeos, recursos, Act. 3 (cuestionario sobre los vídeos), Act. 4 (glosario) |
| Tema 3. Jugadores y entrenadores históricos | Teoría y vídeos, recursos, Act. 5 (cuestionario), Act. 6 (tarea con rúbrica) |
| Tema 4. Palmarés y finales europeas | Teoría y vídeos, recursos, Act. 7 (cuestionario), Act. 8 (tarea con rúbrica) |
| Tema 5. Afición, símbolos y cultura | Teoría y vídeos, recursos, Act. 9 (examen final), Act. 10 (proyecto final) |

Cada tema se divide en dos subsecciones de Moodle 5:

- **Teoría y vídeos:** una página de teoría y una página con vídeos de YouTube incrustados.
- **Recursos:** una página de enlaces recomendados y dos recursos de tipo URL.

## Evaluación

- 5 cuestionarios autocorregidos con 37 preguntas en total (`preguntas-gift/`).
- 3 tareas calificadas con rúbrica (`docs/rubrica.md`).
- 1 foro calificado sobre 10.
- La finalización de actividades está activada en todo el curso.

## Usuarios

| Usuario | Rol |
|---|---|
| youssef | Profesor |
| kevin, edgar, lucia, alex, marcos, hugo, roberto | Estudiante |

La contraseña de cada usuario es su nombre sin tilde seguido de `VCF1919!` (por ejemplo, `KevinVCF1919!`).
Son credenciales de una instalación local de prácticas.

## Contenido del repositorio

```
scripts/moodle-helpers.js       Funciones para automatizar formularios de Moodle desde la consola del navegador
scripts/01-usuarios-y-curso.js  Creación de usuarios, curso y matriculación
preguntas-gift/*.gift           Bancos de preguntas de los cinco cuestionarios (formato GIFT)
docs/rubrica.md                 Rúbrica y ponderación de las actividades
backup/                         Copia de seguridad del curso (.mbz)
```

## Reproducción

1. Restaurar `backup/*.mbz` desde *Administración del sitio > Cursos > Restaurar curso*.
2. Como alternativa, iniciar sesión como administrador, abrir la consola del navegador (F12) y ejecutar
   `scripts/moodle-helpers.js` y después `scripts/01-usuarios-y-curso.js`. Las preguntas se importan
   desde *Banco de preguntas > Importar*, eligiendo el formato GIFT.

## Vídeos utilizados

| Tema | Vídeo (ID de YouTube) |
|---|---|
| 1 | Valencia CF: historia completa (`FwppmBF6skI`), 90 anys d'història (`7ETuy8_4lcw`) |
| 2 | Historia, pasión, leyenda: 100 años (`g0Qyz7wy9fI`), Mestalla: 100 años de historia (`_6x7C3YQcHk`) |
| 3 | Los mejores momentos de Kempes (`_H_aCgeOm5o`) |
| 4 | El año del doblete 2003-04 (`bqH6wb7acoQ`), resumen de la final de Copa 2019 (`mQyhS4n9dbc`) |
| 5 | Mestalla y afición (`dXMUXKYkiLE`), recibimiento en Mestalla (`-ypaTzGc4ww`) |
