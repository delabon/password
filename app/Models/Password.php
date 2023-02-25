<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Password extends Model
{
    use HasFactory;

    /**
     * Generate a 16 character unique password
     * @return string
     */
    public function generate(): string
    {
        $this->code = $this->generate_16_char_code();

        while ($this->is_already_stored($this->code)) {
            $this->code = $this->generate_16_char_code();
        }

        $this->save();

        return $this->code;
    }

    private function generate_16_char_code(): string
    {
        $code = hash('sha512', uniqid(env('PASSWORD_GENERATION_SALT', '213DADAZ558877')));

        return substr($code, 0, 16);
    }

    private function is_already_stored(string $code): bool
    {
        return (bool)DB::table('passwords')->where('code', $code)->count();
    }
}
