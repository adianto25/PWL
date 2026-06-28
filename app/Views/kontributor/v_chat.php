<?= $this->extend('layout') ?>

<?= $this->section('styles') ?>
<style>
    .chat-container { height: 70vh; background-color: #f8f9fa; border-radius: 16px; overflow: hidden; display: flex; border: 1px solid #dee2e6; }
    .chat-sidebar { width: 300px; background: white; border-right: 1px solid #dee2e6; overflow-y: auto; }
    .chat-main { flex-grow: 1; display: flex; flex-direction: column; background: #f0f2f5; }
    .chat-header { padding: 15px 20px; background: white; border-bottom: 1px solid #dee2e6; }
    .chat-messages { flex-grow: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 10px; }
    .chat-input { padding: 15px; background: white; border-top: 1px solid #dee2e6; }
    
    .chat-bubble { max-width: 70%; padding: 10px 15px; border-radius: 15px; position: relative; font-size: 0.95rem; }
    .chat-bubble.sent { background-color: #dcf8c6; align-self: flex-end; border-bottom-right-radius: 0; }
    .chat-bubble.received { background-color: white; align-self: flex-start; border-bottom-left-radius: 0; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
    
    .partner-item { padding: 15px; border-bottom: 1px solid #f1f1f1; cursor: pointer; text-decoration: none; color: inherit; display: block; }
    .partner-item:hover, .partner-item.active { background-color: #f8f9fa; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="chat-container shadow-sm">
        <!-- Sidebar Contacts -->
        <div class="chat-sidebar">
            <div class="p-3 bg-light border-bottom fw-bold">Pesan Masuk</div>
            <?php if(empty($chatPartners)): ?>
                <div class="p-4 text-center text-muted small">Belum ada riwayat chat.</div>
            <?php else: ?>
                <?php foreach($chatPartners as $partner): ?>
                    <a href="<?= base_url('kontributor/chat/'.$partner['id']) ?>" class="partner-item <?= ($activePartner && $activePartner['id'] == $partner['id']) ? 'active' : '' ?>">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">
                                <?= strtoupper(substr($partner['username'], 0, 1)) ?>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold text-dark"><?= esc($partner['username']) ?></h6>
                                <small class="text-muted"><?= esc($partner['role']) ?></small>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        
        <!-- Main Chat Area -->
        <div class="chat-main">
            <?php if(!$activePartner): ?>
                <div class="d-flex align-items-center justify-content-center h-100 flex-column text-muted">
                    <i class="bi bi-chat-dots fs-1 mb-2"></i>
                    <p>Pilih kontak untuk mulai mengobrol</p>
                </div>
            <?php else: ?>
                <div class="chat-header d-flex align-items-center gap-3">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; font-weight: bold;">
                        <?= strtoupper(substr($activePartner['username'], 0, 1)) ?>
                    </div>
                    <h5 class="mb-0 fw-bold"><?= esc($activePartner['username']) ?></h5>
                </div>
                
                <div class="chat-messages" id="chatBox">
                    <?php foreach($messages as $msg): ?>
                        <div class="chat-bubble <?= ($msg['pengirim_id'] == $userId) ? 'sent' : 'received' ?>">
                            <?= esc($msg['pesan']) ?>
                            <div class="text-end" style="font-size: 0.7rem; color: #888; margin-top: 5px;">
                                <?= date('H:i', strtotime($msg['created_at'])) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="chat-input">
                    <form action="<?= base_url('kontributor/chat/send') ?>" method="POST" class="d-flex gap-2">
                        <input type="hidden" name="penerima_id" value="<?= $activePartner['id'] ?>">
                        <input type="text" name="pesan" class="form-control rounded-pill px-4" placeholder="Ketik pesan..." required autocomplete="off" autofocus>
                        <button type="submit" class="btn btn-primary rounded-circle" style="width: 45px; height: 45px;"><i class="bi bi-send-fill"></i></button>
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->section('scripts') ?>
<script>
    // Scroll chat to bottom automatically
    var chatBox = document.getElementById('chatBox');
    if(chatBox) {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
</script>
<?= $this->endSection() ?>
<?= $this->endSection() ?>
