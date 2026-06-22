import os
import re

directory = 'resources/views'

for root, _, files in os.walk(directory):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                content = f.read()

            # Remove existing link for "Struktur Organisasi" with /admin/perangkat
            content = re.sub(r'\s*<li[^>]*><a href="/admin/perangkat".*?</li>', '', content)

            replacement = """            @if(session('role') === 'Sekretaris Desa')
                <p class="menu-title" style="margin-top: 1.5rem;">Manajemen Internal</p>
                <li class="{{ request()->is('admin/perangkat*') ? 'active' : '' }}"><a href="/admin/perangkat"><i class="fa-solid fa-sitemap"></i> Struktur Organisasi</a></li>
            @endif

            @if(session('role') === 'Super Admin')"""

            content = content.replace("@if(session('role') === 'Super Admin')", replacement)

            with open(filepath, 'w', encoding='utf-8') as f:
                f.write(content)

print("Done updating sidebars.")
