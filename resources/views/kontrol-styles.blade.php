<style>
.ctrl-card {
    background: #fff;
    border: none;
    border-radius: 18px;
    box-shadow: 0 5px 18px rgba(0,0,0,.06);
    overflow: hidden;
    transition: .3s;
}
.ctrl-card:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(0,0,0,.1); }

.ctrl-card-header {
    font-size: 12px;
    font-weight: 800;
    color: #475569;
    text-transform: uppercase;
    letter-spacing: .08em;
    padding: 14px 20px;
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    align-items: center;
    gap: 8px;
}

.ctrl-select, .ctrl-input {
    border-radius: 12px;
    border: 1.5px solid #e2e8f0;
    padding: 10px 14px;
    transition: border-color .2s;
}
.ctrl-select:focus, .ctrl-input:focus {
    border-color: #4f46e5;
    box-shadow: 0 0 0 3px rgba(79,70,229,.1);
}

.ctrl-btn {
    border-radius: 12px;
    padding: 10px;
    font-weight: 700;
    font-size: 14px;
    transition: all .25s ease;
    border: none;
}
.ctrl-btn:hover { transform: translateY(-1px); }

/* Device cards (Manual mode) */
.device-icon {
    width: 56px; height: 56px;
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
    margin: 0 auto 12px;
}
.bg-danger-soft { background: #fee2e2; }
.bg-purple-soft { background: #ede9fe; }
.bg-info-soft   { background: #e0f2fe; }
.text-purple    { color: #7c3aed; }

.device-label {
    font-size: 12px; font-weight: 800;
    color: #64748b; text-transform: uppercase;
    letter-spacing: .08em; margin-bottom: 4px;
}
.device-status {
    font-size: 28px; font-weight: 800;
    margin: 8px 0 16px;
}

/* Timeline */
.timeline-list { position: relative; padding-left: 24px; }
.timeline-list::before {
    content: '';
    position: absolute;
    left: 9px; top: 0; bottom: 0;
    width: 2px;
    background: #e2e8f0;
}

.tl-item {
    position: relative;
    padding: 10px 0 10px 16px;
    display: flex;
    align-items: flex-start;
    gap: 10px;
}

.tl-dot {
    position: absolute;
    left: -23px; top: 12px;
    width: 20px; height: 20px;
    border-radius: 50%;
    background: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px;
    border: 2px solid #e2e8f0;
    z-index: 1;
}
.tl-active .tl-dot { border-color: #3b82f6; }
.tl-done .tl-dot   { border-color: #10b981; }

.tl-content { flex: 1; }

@media (max-width: 575.98px) {
    .device-status { font-size: 22px; }
    .device-icon { width: 46px; height: 46px; font-size: 20px; }
}
</style>
