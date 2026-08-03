<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactMessage extends Model
{
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'is_read',
    ];

    protected $attributes = [
        'is_read' => false,
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public static function tableReady(): bool
    {
        try {
            if (Schema::hasTable('contact_messages')) {
                return true;
            }

            Schema::create('contact_messages', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->nullable();
                $table->string('subject')->nullable();
                $table->text('message');
                $table->boolean('is_read')->default(false)->index();
                $table->timestamps();
            });

            return Schema::hasTable('contact_messages');
        } catch (\Throwable $e) {
            return false;
        }
    }
}
