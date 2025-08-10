<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;

class ArticleComments extends Component
{
    public Article $article;
    public ?int $replyingTo = null;

    // Menyimpan daftar ID komentar yang reply-nya sedang ditampilkan
    public array $visibleReplies = [];

    public array $mainComment = [
        'body' => '',
        'guest_name' => '',
        'guest_email' => '',
        'honeypot' => '',
    ];

    public array $replyComment = [
        'body' => '',
        'guest_name' => '',
        'guest_email' => '',
        'honeypot' => '',
    ];

    public function mount(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Menampilkan atau menyembunyikan daftar balasan dari sebuah komentar
     */
    public function toggleReplies(int $commentId)
    {
        if (in_array($commentId, $this->visibleReplies)) {
            // Hapus dari daftar -> sembunyikan
            $this->visibleReplies = array_values(array_diff($this->visibleReplies, [$commentId]));
        } else {
            // Tambahkan ke daftar -> tampilkan
            $this->visibleReplies[] = $commentId;
        }
    }

    /**
     * Memulai membalas komentar
     */
    public function startReply(int $commentId)
    {
        $this->replyingTo = $commentId;
        $this->reset('replyComment');
    }

    /**
     * Membatalkan proses membalas komentar
     */
    public function cancelReply()
    {
        $this->replyingTo = null;
    }

    /**
     * Menambahkan komentar utama
     */
    public function addMainComment()
    {
        $rules = [
            'mainComment.body' => 'required|min:3|max:1000',
            'mainComment.honeypot' => 'prohibited',
        ];

        if (auth()->guest()) {
            $rules['mainComment.guest_name'] = 'required|string|max:255';
            $rules['mainComment.guest_email'] = 'required|email|max:255';
        }

        $this->validate($rules);

        $commentData = [
            'body' => $this->mainComment['body'],
        ];

        if (auth()->check()) {
            $commentData['user_id'] = auth()->id();
        } else {
            $commentData['guest_name'] = $this->mainComment['guest_name'];
            $commentData['guest_email'] = $this->mainComment['guest_email'];
        }

        $this->article->comments()->create($commentData);

        $this->reset('mainComment');
        session()->flash('message', 'Komentar berhasil ditambahkan!');
    }

    /**
     * Menambahkan balasan komentar
     */
    public function addReply()
    {
        if (!$this->replyingTo) {
            return;
        }

        $rules = [
            'replyComment.body' => 'required|min:3|max:1000',
            'replyComment.honeypot' => 'prohibited',
        ];

        if (auth()->guest()) {
            $rules['replyComment.guest_name'] = 'required|string|max:255';
            $rules['replyComment.guest_email'] = 'required|email|max:255';
        }

        $this->validate($rules);

        $commentData = [
            'body' => $this->replyComment['body'],
            'parent_id' => $this->replyingTo,
        ];

        if (auth()->check()) {
            $commentData['user_id'] = auth()->id();
        } else {
            $commentData['guest_name'] = $this->replyComment['guest_name'];
            $commentData['guest_email'] = $this->replyComment['guest_email'];
        }

        $this->article->comments()->create($commentData);

        $this->reset('replyComment', 'replyingTo');
        session()->flash('message', 'Balasan berhasil dikirim!');
    }

    /**
     * Render view
     */
    public function render()
    {
        $comments = $this->article->comments()
            ->whereNull('parent_id')
            ->with([
                'user',
                'replies.user'
            ])
            ->latest()
            ->get();

        return view('livewire.article-comments', [
            'comments' => $comments,
        ]);
    }

    public function deleteComment($commentId)
{
    $comment = $this->article->comments()->find($commentId);
    if ($comment) {
        $comment->delete();
        session()->flash('message', 'Komentar berhasil dihapus!');
    }
}

}
