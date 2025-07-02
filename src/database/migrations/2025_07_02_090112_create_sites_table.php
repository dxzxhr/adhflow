<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Таблица площадок веб-мастеров.
     *
     *  - user_id        владелец (users.id)
     *  - domain         уникальный домен (example.com)
     *  - niche          IAB-категория / тематика
     *  - status         pending | active | rejected
     *  - check_report   JSON-отчёт Lighthouse / проверок
     */
    public function up(): void
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();

            // владелец площадки
            $table->foreignId('user_id')
                  ->constrained()
                  ->cascadeOnDelete();

            // домен площадки
            $table->string('domain')->unique();

            // IAB-категория или «niche»
            $table->string('niche')->nullable();

            // статус модерации
            $table->enum('status', ['pending', 'active', 'rejected'])
                  ->default('pending')
                  ->index();

            // отчёт проверки (JSON, Postgres хранит как JSONB)
            $table->json('check_report')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Откат миграции.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
