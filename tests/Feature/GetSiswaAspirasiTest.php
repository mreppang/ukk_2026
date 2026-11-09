<?php

use App\Filament\Siswa\Widgets\GetSiswaAspirasi;
use App\Models\Aspirasi;
use App\Models\Category;
use App\Models\Siswa;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('shows zero stats until a siswa is selected', function () {
    Filament::setCurrentPanel(Filament::getPanel('siswa'));

    $siswa = Siswa::create(['nama' => 'Budi', 'kelas' => 'XII', 'nisn' => '123']);
    $category = Category::create(['nama' => 'Sarana']);

    $statuses = ['menunggu', 'menunggu', 'proses'];

    foreach ($statuses as $status) {
        Aspirasi::create([
            'siswa_id' => $siswa->id,
            'category_id' => $category->id,
            'nama' => 'Test',
            'tempat' => 'Kelas',
            'deskripsi' => 'Test',
            'feedback' => '',
            'status' => $status,
        ]);
    }

    Livewire::test(GetSiswaAspirasi::class)
        ->assertSeeInOrder(['Menunggu', '0', 'Proses', '0', 'Selesai', '0'])
        ->set('filters.siswa_id', $siswa->id)
        ->assertSeeInOrder(['Menunggu', '2', 'Proses', '1', 'Selesai', '0']);
});
