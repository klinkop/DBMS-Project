<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Contact extends Model
{

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'SC',
        'status',
        'company',
        'pic',
        'email',
        'contact1',
        'contact2',
        'industry',
        'city',
        'state'
    ];

    public static function getContactsInFolder($folderId)
    {
        return DB::select("
            WITH RECURSIVE contact_tree AS (
                SELECT
                    id,
                    name,
                    parent_id,
                    1 AS level
                FROM contacts
                WHERE id = ?

                UNION ALL

                SELECT
                    c.id,
                    c.name,
                    c.parent_id,
                    ct.level + 1
                FROM contacts c
                INNER JOIN contact_tree ct ON ct.id = c.parent_id
            )
            SELECT * FROM contact_tree;
        ", [$folderId]);
    }

        /**
     * Get only the parent folders.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getParentFolders()
    {
        return DB::table('contacts')
            ->whereNull('parent_id')
            ->get(['id', 'name']);
    }

        /**
     * Get child folders for a given parent folder.
     *
     * @param int $parentId
     * @return \Illuminate\Support\Collection
     */
    public static function getChildFolders($parentId)
    {
        return DB::table('contacts')
            ->where('parent_id', $parentId)
            ->get(['id', 'name']);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($contact) {
            if (is_null($contact->parent_id)) {
                $contact->parent_id = null; // Ensure parent_id is null by default
            }
        });
    }

    public static function getContactsAsList($folderId)
    {
        return DB::select("
            WITH RECURSIVE contact_tree AS (
                SELECT
                    id,
                    name,
                    parent_id,
                    2 AS level
                FROM contacts
                WHERE id = ?

                UNION ALL

                SELECT
                    c.id,
                    c.name,
                    c.parent_id,
                    ct.level + 1
                FROM contacts c
                INNER JOIN contact_tree ct ON ct.id = c.parent_id
            )
            SELECT * FROM contact_tree;
        ", [$folderId]);
    }

}
