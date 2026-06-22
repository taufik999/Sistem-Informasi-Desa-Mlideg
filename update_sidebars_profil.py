import os
import glob

files = glob.glob(r'c:\Users\taufi\Downloads\tugasakhir\resources\views\*.blade.php')

new_menu = '                <li class="{{ request()->is(\'admin/profil\') ? \'active\' : \'\' }}"><a href="/admin/profil"><i class="fa-solid fa-address-card"></i> Pengaturan Profil</a></li>\n'
new_menu_fallback = '            <li class="{{ request()->is(\'admin/profil\') ? \'active\' : \'\' }}"><a href="/admin/profil"><i class="fa-solid fa-address-card"></i> Pengaturan Profil</a></li>\n'

for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
        
    if '<ul class="sidebar-menu">' not in content:
        continue
        
    if 'Pengaturan Profil' in content and 'admin/profil' in content:
        continue
        
    # We will insert it after Pengaturan Beranda
    if 'Pengaturan Beranda</a></li>' in content:
        parts = content.split('Pengaturan Beranda</a></li>')
        
        if '                <li><a href="/admin/berita"' in parts[1]:
            parts[1] = '\n' + new_menu + parts[1].lstrip('\n')
        else:
            parts[1] = '\n' + new_menu_fallback + parts[1].lstrip('\n')
            
        new_content = 'Pengaturan Beranda</a></li>'.join(parts)
        
        with open(file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Updated {file}")
    elif '<p class="menu-title" style="margin-top: 1.5rem;">Kelola Konten</p>' in content:
        # Fallback if Beranda is not there yet for some reason
        parts = content.split('<p class="menu-title" style="margin-top: 1.5rem;">Kelola Konten</p>')
        
        if '                <li><a href="/admin/berita"' in parts[1]:
            parts[1] = '\n' + new_menu + parts[1].lstrip('\n')
        else:
            parts[1] = '\n' + new_menu_fallback + parts[1].lstrip('\n')
            
        new_content = '<p class="menu-title" style="margin-top: 1.5rem;">Kelola Konten</p>'.join(parts)
        
        with open(file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Updated {file}")

# Update layouts/admin.blade.php as well
layout_file = r'c:\Users\taufi\Downloads\tugasakhir\resources\views\layouts\admin.blade.php'
with open(layout_file, 'r', encoding='utf-8') as f:
    content = f.read()

if 'Pengaturan Profil' not in content:
    parts = content.split('Pengaturan Beranda</a></li>')
    if len(parts) > 1:
        parts[1] = '\n                <li class="{{ request()->is(\'admin/profil\') ? \'active\' : \'\' }}"><a href="/admin/profil"><i class="fa-solid fa-address-card"></i> Pengaturan Profil</a></li>\n' + parts[1].lstrip('\n')
        new_content = 'Pengaturan Beranda</a></li>'.join(parts)
        with open(layout_file, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Updated {layout_file}")

print("Done updating sidebars with Profil.")
