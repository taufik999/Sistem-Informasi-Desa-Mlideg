import os
import glob

# Daftar file yang perlu diperbarui
files = glob.glob(r'c:\Users\taufi\Downloads\tugasakhir\resources\views\*.blade.php')

new_menu = '                <li class="{{ request()->is(\'admin/beranda\') ? \'active\' : \'\' }}"><a href="/admin/beranda"><i class="fa-solid fa-home"></i> Pengaturan Beranda</a></li>\n'
new_menu_fallback = '            <li class="{{ request()->is(\'admin/beranda\') ? \'active\' : \'\' }}"><a href="/admin/beranda"><i class="fa-solid fa-home"></i> Pengaturan Beranda</a></li>\n'

for file in files:
    # Skip layouts/admin.blade.php as it's already updated and structure might be slightly different
    if 'layouts' in file:
        continue
        
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
        
    if '<ul class="sidebar-menu">' not in content:
        continue
        
    # Check if already added
    if 'Pengaturan Beranda' in content and 'admin/beranda' in content:
        continue
        
    # Find "Kelola Konten" and insert right after it
    if '<p class="menu-title" style="margin-top: 1.5rem;">Kelola Konten</p>' in content:
        # Some files have indentation of 16 spaces, some 12
        parts = content.split('<p class="menu-title" style="margin-top: 1.5rem;">Kelola Konten</p>')
        
        # Determine indentation for replacement
        if '                <li><a href="/admin/berita"' in parts[1]:
            parts[1] = '\n' + new_menu + parts[1].lstrip('\n')
        else:
            parts[1] = '\n' + new_menu_fallback + parts[1].lstrip('\n')
            
        new_content = '<p class="menu-title" style="margin-top: 1.5rem;">Kelola Konten</p>'.join(parts)
        
        with open(file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Updated {file}")
    else:
        print(f"Could not find 'Kelola Konten' in {file}")

print("Done updating sidebars.")
