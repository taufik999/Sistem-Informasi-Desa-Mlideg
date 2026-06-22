<?php
/**
 * Script to replace all inline sidebars with @include('partials.sidebar')
 * in all blade files that have their own sidebar.
 */

$viewsDir = __DIR__ . '/resources/views';

// Files that have inline sidebars (not using layouts.admin)
$files = [
    'dashboard.blade.php',
    'penduduk.blade.php',
    'pengaduan.blade.php',
    'surat-admin.blade.php',
    'berita-admin.blade.php',
    'galeri-admin.blade.php',
    'potensi-admin.blade.php',
    'perangkat-admin.blade.php',
    'tambah-penduduk.blade.php',
    'tambah-perangkat.blade.php',
    'tambah-berita.blade.php',
    'edit-penduduk.blade.php',
    'edit-perangkat.blade.php',
    'edit-berita.blade.php',
    'detail-penduduk.blade.php',
    'detail-perangkat.blade.php',
    'detail-berita-admin.blade.php',
    'beranda-admin.blade.php',
    'profil-desa-admin.blade.php',
    'kk-admin.blade.php',
    'edit-kk.blade.php',
    'detail-kk.blade.php',
];

$count = 0;

foreach ($files as $file) {
    $path = $viewsDir . '/' . $file;
    if (!file_exists($path)) {
        echo "SKIP: $file (not found)\n";
        continue;
    }

    $content = file_get_contents($path);
    
    // Pattern: match <aside class="sidebar"> ... </aside>
    // This regex finds the entire sidebar block
    $pattern = '/<aside\s+class="sidebar">\s*.*?<\/aside>/s';
    
    if (preg_match($pattern, $content)) {
        $newContent = preg_replace(
            $pattern, 
            "@include('partials.sidebar')", 
            $content,
            1 // Only replace first occurrence
        );
        
        if ($newContent !== $content) {
            // Also remove any $p_surat / $p_adu / $role / $user @php blocks that were
            // defined right before the sidebar in the same scope
            // (only if they're now orphaned - we keep them if used elsewhere)
            
            file_put_contents($path, $newContent);
            echo "FIXED: $file\n";
            $count++;
        } else {
            echo "NO CHANGE: $file\n";
        }
    } else {
        echo "NO SIDEBAR: $file\n";
    }
}

echo "\n=== Done! Fixed $count files ===\n";
