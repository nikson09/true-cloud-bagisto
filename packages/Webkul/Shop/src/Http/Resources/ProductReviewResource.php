<?php

namespace Webkul\Shop\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->sanitizeUtf8($this->name),
            'title'      => $this->sanitizeUtf8($this->title),
            'comment'    => $this->sanitizeUtf8($this->comment),
            'rating'     => $this->rating,
            'images'     => $this->images,
            'profile'    => $this->customer?->image_url,
            'created_at' => $this->created_at->format('M d, Y'),
        ];
    }

    /**
     * Sanitize UTF-8 string to prevent JSON encoding errors
     *
     * @param string|null $string
     * @return string|null
     */
    private function sanitizeUtf8($string)
    {
        if (is_null($string)) {
            return null;
        }

        // Convert to UTF-8 and remove invalid sequences
        $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        
        // Remove null bytes and other control characters that can cause JSON issues
        $string = str_replace(["\0", "\x00"], '', $string);
        
        // Remove any remaining invalid UTF-8 sequences
        $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $string);
        
        // Ensure the string is valid UTF-8
        if (!mb_check_encoding($string, 'UTF-8')) {
            $string = mb_convert_encoding($string, 'UTF-8', 'UTF-8');
        }
        
        return $string;
    }
}
