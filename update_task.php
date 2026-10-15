<?php

$file = 'C:/Users/LENOVO/.gemini/antigravity/brain/01f2430c-0fea-4cff-ac17-fcd49b2a35da/task.md';
$content = file_get_contents($file);

$content = str_replace('`[/]` 2. **Pendaftaran (Frontend & Controller)**', '`[x]` 2. **Pendaftaran (Frontend & Controller)**', $content);
$content = str_replace('`[ ]` 3. **Validasi Login**', '`[x]` 3. **Validasi Login**', $content);
$content = str_replace('`[ ]` 4. **Dashboard Admin (Verifikasi)**', '`[/]` 4. **Dashboard Admin (Verifikasi)**', $content);

file_put_contents($file, $content);
