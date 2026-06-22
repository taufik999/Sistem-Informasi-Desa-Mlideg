import os
import re

directory = 'resources/views'

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()

            if "Sekretaris Desa" in content and "Manajemen Internal" in content:
                # Remove the entire Sekretaris Desa block
                content = re.sub(r'\s*@if\(session\(\'role\'\) === \'Sekretaris Desa\'\)\s*<p class="menu-title".*?Manajemen Internal.*?</p>\s*<li.*?Struktur Organisasi.*?</li>\s*@endif\s*', '\n            ', content)
                
                # Check if 'Super Admin' block already has 'Struktur Organisasi'
                if "Struktur Organisasi" not in content.split("@if(session('role') === 'Super Admin')")[-1]:
                    # Add it back after Potensi Desa
                    content = re.sub(
                        r'(<li><a href="/admin/potensi"><i class="fa-solid fa-seedling"></i> Potensi Desa</a></li>)',
                        r'\1\n                <li class="{{ request()->is(\'admin/perangkat*\') ? \'active\' : \'\' }}"><a href="/admin/perangkat"><i class="fa-solid fa-sitemap"></i> Struktur Organisasi</a></li>',
                        content
                    )
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.write(content)
                print(f"Reverted {filepath}")

print("Revert complete")
