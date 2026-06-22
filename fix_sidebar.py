import glob

files = glob.glob(r'c:\Users\taufi\Downloads\tugasakhir\resources\views\*.blade.php')

# Tambahkan juga layouts/admin.blade.php
files.append(r'c:\Users\taufi\Downloads\tugasakhir\resources\views\layouts\admin.blade.php')

new_menu = '                <li class="{{ request()->is(\'admin/profil\') ? \'active\' : \'\' }}"><a href="/admin/profil"><i class="fa-solid fa-address-card"></i> Pengaturan Profil</a></li>\n'
new_menu_fallback = '            <li class="{{ request()->is(\'admin/profil\') ? \'active\' : \'\' }}"><a href="/admin/profil"><i class="fa-solid fa-address-card"></i> Pengaturan Profil</a></li>\n'

count = 0

for file in files:
    try:
        with open(file, 'r', encoding='utf-8') as f:
            content = f.read()
            
        if 'admin/profil' in content and 'Pengaturan Profil' in content:
            continue
            
        # Target string to search
        target = 'Pengaturan Beranda</a></li>'
        
        if target in content:
            # Ganti string target dengan string target + menu baru
            parts = content.split(target)
            
            # Cek identasi untuk baris berikutnya
            if '                <li><a href="/admin/berita' in parts[1]:
                replacement = target + '\n' + new_menu
            else:
                replacement = target + '\n' + new_menu_fallback
                
            new_content = content.replace(target, replacement)
            
            with open(file, 'w', encoding='utf-8') as f:
                f.write(new_content)
            
            print(f"Berhasil memperbarui: {file}")
            count += 1
    except Exception as e:
        print(f"Error pada {file}: {e}")

print(f"Selesai! {count} file telah diperbarui.")
