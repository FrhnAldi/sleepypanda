@extends('layouts.app')

@section('title', 'Database User')

@section('content')
<style>
    .db-user-container {
        padding: 30px;
        max-width: 1600px;
        margin: 0 auto;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        background: rgba(255, 255, 255, 0.05);
        transform: translateY(-3px);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }

    .stat-icon svg {
        width: 32px;
        height: 32px;
        stroke-width: 2.5;
    }

    .stat-icon.total {
        background: rgba(102, 126, 234, 0.15);
        color: #667eea;
    }

    .stat-icon.active {
        background: rgba(46, 213, 115, 0.15);
        color: #2ed573;
    }

    .stat-icon.new {
        background: rgba(255, 159, 67, 0.15);
        color: #ff9f43;
    }

    .stat-icon.inactive {
        background: rgba(255, 107, 107, 0.15);
        color: #ff6b6b;
    }

    .stat-info {
        flex: 1;
    }

    .stat-label {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.6);
        margin-bottom: 5px;
        font-weight: 500;
    }

    .stat-value {
        font-size: 32px;
        font-weight: 700;
        color: white;
    }

    .toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        gap: 20px;
        flex-wrap: wrap;
    }

    .search-box {
        flex: 1;
        max-width: 500px;
        position: relative;
    }

    .search-box input {
        width: 100%;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 14px 20px 14px 50px;
        color: white;
        font-size: 15px;
        outline: none;
        transition: all 0.3s ease;
    }

    .search-box input:focus {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(102, 126, 234, 0.5);
    }

    .search-box input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .search-box svg {
        position: absolute;
        left: 18px;
        top: 50%;
        transform: translateY(-50%);
        color: rgba(255, 255, 255, 0.4);
    }

    .toolbar-actions {
        display: flex;
        gap: 12px;
    }

    .btn-toolbar {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        padding: 14px 24px;
        color: white;
        font-size: 15px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-toolbar:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.2);
    }

    .users-table-container {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        overflow: hidden;
    }

    .users-table {
        width: 100%;
        border-collapse: collapse;
    }

    .users-table thead {
        background: rgba(255, 255, 255, 0.05);
    }

    .users-table th {
        padding: 20px 25px;
        text-align: left;
        font-size: 14px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.8);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .users-table tbody tr {
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .users-table tbody tr:hover {
        background: rgba(255, 255, 255, 0.05);
    }

    .users-table tbody tr.selected {
        background: rgba(102, 126, 234, 0.15);
        border-color: rgba(102, 126, 234, 0.3);
    }

    .users-table tbody tr:last-child {
        border-bottom: none;
    }

    .users-table td {
        padding: 20px 25px;
        font-size: 15px;
        color: rgba(255, 255, 255, 0.9);
    }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-avatar-table {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 16px;
        flex-shrink: 0;
    }

    .user-details {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .user-name-text {
        font-weight: 600;
        font-size: 15px;
    }

    .user-id {
        font-size: 13px;
        color: rgba(255, 255, 255, 0.5);
    }

    .contact-info {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.7);
    }

    .contact-item svg {
        width: 16px;
        height: 16px;
        color: rgba(255, 255, 255, 0.4);
    }

    .sleep-status {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .sleep-item {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.8);
    }

    .sleep-item span:first-child {
        color: rgba(255, 255, 255, 0.5);
        margin-right: 8px;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 8px 18px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .status-badge.active {
        background: rgba(46, 213, 115, 0.15);
        color: #2ed573;
    }

    .status-badge.inactive {
        background: rgba(255, 107, 107, 0.15);
        color: #ff6b6b;
    }

    .last-active-text {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.7);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 3000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.75);
        backdrop-filter: blur(8px);
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background: #252842;
        border-radius: 20px;
        padding: 40px;
        width: 90%;
        max-width: 550px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
        from {
            transform: translateY(30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .modal-title {
        font-size: 26px;
        font-weight: 700;
        color: white;
    }

    .modal-subtitle {
        font-size: 14px;
        color: rgba(255, 255, 255, 0.6);
        margin-top: 8px;
    }

    .close-modal {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        color: rgba(255, 255, 255, 0.7);
        cursor: pointer;
        font-size: 24px;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }

    .close-modal:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        font-size: 14px;
        color: rgba(255, 255, 255, 0.9);
    }

    .form-input {
        width: 100%;
        padding: 14px 18px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 12px;
        color: white;
        font-size: 15px;
        transition: all 0.3s ease;
    }

    .form-input:focus {
        outline: none;
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(102, 126, 234, 0.5);
    }

    .form-input::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .form-input:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .error-message {
        color: #ff6b6b;
        font-size: 13px;
        margin-top: 8px;
        display: none;
    }

    .error-message.show {
        display: block;
    }

    .success-message {
        background: rgba(46, 213, 115, 0.15);
        border: 1px solid rgba(46, 213, 115, 0.3);
        color: #2ed573;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: none;
        font-size: 14px;
        font-weight: 500;
    }

    .success-message.show {
        display: block;
    }

    .btn-submit {
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        color: white;
        font-size: 16px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
    }

    .btn-submit:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255, 255, 255, 0.5);
    }

    .empty-state svg {
        width: 80px;
        height: 80px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    /* User Selection Mode */
    .selection-mode-active .users-table tbody tr {
        cursor: pointer;
    }

    .selection-mode-active .users-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.1);
    }

    .selection-info {
        background: rgba(102, 126, 234, 0.15);
        border: 1px solid rgba(102, 126, 234, 0.3);
        color: #8b9cff;
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 30px;
        font-size: 14px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .selection-info svg {
        width: 20px;
        height: 20px;
    }

    @media (max-width: 1200px) {
        .users-table {
            font-size: 14px;
        }

        .users-table th,
        .users-table td {
            padding: 15px 20px;
        }
    }

    @media (max-width: 968px) {
        .db-user-container {
            padding: 20px;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-box {
            max-width: 100%;
        }

        .users-table-container {
            overflow-x: auto;
        }

        .users-table {
            min-width: 1000px;
        }
    }

    @media (max-width: 640px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-value {
            font-size: 28px;
        }

        .modal-content {
            padding: 30px 20px;
        }
    }
</style>

<div class="db-user-container">
    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon total">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Users</div>
                <div class="stat-value">{{ $totalUsers }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Active Users</div>
                <div class="stat-value">{{ $activeUsers }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon new">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">New Users</div>
                <div class="stat-value">{{ $newUsers }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon inactive">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-label">Inactive Users</div>
                <div class="stat-value">{{ $inactiveUsers }}</div>
            </div>
        </div>
    </div>

    <!-- Selection Info (Hidden by default) -->
    <div class="selection-info" id="selectionInfo" style="display: none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="12" cy="12" r="10"></circle>
            <line x1="12" y1="16" x2="12" y2="12"></line>
            <line x1="12" y1="8" x2="12.01" y2="8"></line>
        </svg>
        <span id="selectionText">Pilih user dari tabel di bawah untuk melanjutkan</span>
    </div>

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="search-box">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="text" id="searchInput" placeholder="Search by name, email, or ID">
        </div>
        <div class="toolbar-actions">
            <button class="btn-toolbar" id="sortBtn">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 6h18M7 12h10M11 18h2"></path>
                </svg>
                Sort by
            </button>
            <button class="btn-toolbar" onclick="window.location.reload()">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2"></path>
                </svg>
                Refresh
            </button>
        </div>
    </div>

    <!-- Users Table -->
    <div class="users-table-container" id="usersTableContainer">
        <table class="users-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Contact</th>
                    <th>Sleep Status</th>
                    <th>Status</th>
                    <th>Last Active</th>
                </tr>
            </thead>
            <tbody id="usersTableBody">
                @forelse($users as $user)
                <tr class="user-row" data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}" data-user-email="{{ $user->email }}" data-user-phone="{{ $user->phone }}">
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar-table">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="user-details">
                                <div class="user-name-text">{{ $user->name }}</div>
                                <div class="user-id">ID #{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="contact-info">
                            <div class="contact-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                    <polyline points="22,6 12,13 2,6"></polyline>
                                </svg>
                                {{ $user->email }}
                            </div>
                            @if($user->phone)
                            <div class="contact-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                                {{ $user->phone }}
                            </div>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="sleep-status">
                            <div class="sleep-item">
                                <span>Avg. Sleep:</span> {{ rand(5, 9) }}.{{ rand(0, 9) }}h
                            </div>
                            <div class="sleep-item">
                                <span>Quality:</span> {{ rand(50, 100) }}%
                            </div>
                        </div>
                    </td>
                    <td>
                        @if($user->updated_at >= \Carbon\Carbon::now()->subDays(7))
                            <span class="status-badge active">Active</span>
                        @else
                            <span class="status-badge inactive">Not Active</span>
                        @endif
                    </td>
                    <td>
                        <div class="last-active-text">
                            {{ $user->updated_at->format('Y-m-d') }}<br>
                            {{ $user->updated_at->format('H:i') }}
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                            <p style="font-size: 18px; margin-top: 10px;">Belum ada data user</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Update Data Modal -->
<div id="updateModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h2 class="modal-title">Update Data User</h2>
                <p class="modal-subtitle" id="updateModalSubtitle">Memperbarui data pengguna</p>
            </div>
            <button class="close-modal" onclick="closeModal('updateModal')">&times;</button>
        </div>
        
        <div id="updateSuccessMessage" class="success-message"></div>
        
        <form id="updateForm">
            <input type="hidden" id="updateUserId">
            
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" id="updateName" class="form-input" placeholder="Masukkan nama lengkap">
                <div id="updateNameError" class="error-message"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" id="updateEmail" class="form-input" placeholder="Masukkan email">
                <div id="updateEmailError" class="error-message"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor Telepon</label>
                <input type="text" id="updatePhone" class="form-input" placeholder="Masukkan nomor telepon (opsional)">
                <div id="updatePhoneError" class="error-message"></div>
            </div>

            <button type="submit" class="btn-submit" id="updateSubmitBtn">
                Update Data
            </button>
        </form>
    </div>
</div>

<!-- Reset Password Modal -->
<div id="resetPasswordModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <div>
                <h2 class="modal-title">Reset Password</h2>
                <p class="modal-subtitle" id="resetModalSubtitle">Mengatur ulang password pengguna</p>
            </div>
            <button class="close-modal" onclick="closeModal('resetPasswordModal')">&times;</button>
        </div>
        
        <div id="resetSuccessMessage" class="success-message"></div>
        
        <form id="resetPasswordForm">
            <input type="hidden" id="resetUserId">
            
            <div class="form-group">
                <label class="form-label">Nama User</label>
                <input type="text" id="resetUserName" class="form-input" readonly disabled>
            </div>

            <div class="form-group">
                <label class="form-label">Password Baru</label>
                <input type="password" id="newPassword" class="form-input" placeholder="Minimal 8 karakter">
                <div id="newPasswordError" class="error-message"></div>
            </div>

            <div class="form-group">
                <label class="form-label">Konfirmasi Password Baru</label>
                <input type="password" id="newPasswordConfirmation" class="form-input" placeholder="Ulangi password baru">
                <div id="newPasswordConfirmationError" class="error-message"></div>
            </div>

            <button type="submit" class="btn-submit" id="resetSubmitBtn">
                Reset Password
            </button>
        </form>
    </div>
</div>

<script>
    // CSRF Token Setup
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    
    // Selection mode state
    let selectionMode = null; // 'update' or 'reset'

    // Check URL parameter untuk auto-enable selection mode
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const action = urlParams.get('action');
        
        if (action === 'update') {
            enableSelectionMode('update');
        } else if (action === 'reset') {
            enableSelectionMode('reset');
        }
    });

    // Search Functionality
    document.getElementById('searchInput').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const rows = document.querySelectorAll('.user-row');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });

    // Enable selection mode
    function enableSelectionMode(mode) {
        selectionMode = mode;
        const container = document.getElementById('usersTableContainer');
        const selectionInfo = document.getElementById('selectionInfo');
        const selectionText = document.getElementById('selectionText');
        
        container.classList.add('selection-mode-active');
        selectionInfo.style.display = 'flex';
        
        if (mode === 'update') {
            selectionText.textContent = 'Pilih user yang ingin diupdate datanya dari tabel di bawah';
        } else if (mode === 'reset') {
            selectionText.textContent = 'Pilih user yang ingin direset passwordnya dari tabel di bawah';
        }

        // Smooth scroll to selection info
        setTimeout(() => {
            selectionInfo.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 100);
    }

    // Disable selection mode
    function disableSelectionMode() {
        selectionMode = null;
        const container = document.getElementById('usersTableContainer');
        const selectionInfo = document.getElementById('selectionInfo');
        const rows = document.querySelectorAll('.user-row');
        
        container.classList.remove('selection-mode-active');
        selectionInfo.style.display = 'none';
        
        rows.forEach(row => row.classList.remove('selected'));
        
        // Remove action parameter from URL
        const url = new URL(window.location);
        url.searchParams.delete('action');
        window.history.replaceState({}, '', url);
    }

    // Handle user row click
    document.addEventListener('click', function(e) {
        const row = e.target.closest('.user-row');
        
        if (row && selectionMode) {
            const userId = row.getAttribute('data-user-id');
            const userName = row.getAttribute('data-user-name');
            const userEmail = row.getAttribute('data-user-email');
            const userPhone = row.getAttribute('data-user-phone');
            
            if (selectionMode === 'update') {
                openUpdateModal(userId, userName, userEmail, userPhone);
            } else if (selectionMode === 'reset') {
                openResetPasswordModal(userId, userName);
            }
            
            disableSelectionMode();
        }
    });

    // Open Update Modal
    function openUpdateModal(userId, userName, userEmail, userPhone) {
        document.getElementById('updateUserId').value = userId;
        document.getElementById('updateName').value = userName;
        document.getElementById('updateEmail').value = userEmail;
        document.getElementById('updatePhone').value = userPhone || '';
        document.getElementById('updateModalSubtitle').textContent = 'Memperbarui data: ' + userName;
        
        clearErrors('update');
        document.getElementById('updateSuccessMessage').classList.remove('show');
        
        document.getElementById('updateModal').classList.add('show');
    }

    // Open Reset Password Modal
    function openResetPasswordModal(userId, userName) {
        document.getElementById('resetUserId').value = userId;
        document.getElementById('resetUserName').value = userName;
        document.getElementById('resetModalSubtitle').textContent = 'Mereset password: ' + userName;
        document.getElementById('newPassword').value = '';
        document.getElementById('newPasswordConfirmation').value = '';
        
        clearErrors('reset');
        clearErrors('newPassword');
        document.getElementById('resetSuccessMessage').classList.remove('show');
        
        document.getElementById('resetPasswordModal').classList.add('show');
    }

    // Close Modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('show');
        disableSelectionMode();
    }

    // Clear Errors
    function clearErrors(prefix) {
        const errorElements = document.querySelectorAll('[id^="' + prefix + '"][id$="Error"]');
        errorElements.forEach(el => {
            el.classList.remove('show');
            el.textContent = '';
        });
    }

    // Handle Update Form Submit
    document.getElementById('updateForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const userId = document.getElementById('updateUserId').value;
        const submitBtn = document.getElementById('updateSubmitBtn');
        
        clearErrors('update');
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Memproses...';
        
        const formData = {
            name: document.getElementById('updateName').value,
            email: document.getElementById('updateEmail').value,
            phone: document.getElementById('updatePhone').value,
        };

        try {
            const response = await fetch('/database-user/' + userId, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (data.success) {
                const successMsg = document.getElementById('updateSuccessMessage');
                successMsg.textContent = data.message;
                successMsg.classList.add('show');
                
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                if (data.errors) {
                    for (const field in data.errors) {
                        const fieldName = field.charAt(0).toUpperCase() + field.slice(1);
                        const errorElement = document.getElementById('update' + fieldName + 'Error');
                        if (errorElement) {
                            errorElement.textContent = data.errors[field][0];
                            errorElement.classList.add('show');
                        }
                    }
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Update Data';
        }
    });

    // Handle Reset Password Form Submit
    document.getElementById('resetPasswordForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const userId = document.getElementById('resetUserId').value;
        const submitBtn = document.getElementById('resetSubmitBtn');
        
        clearErrors('reset');
        clearErrors('newPassword');
        
        submitBtn.disabled = true;
        submitBtn.textContent = 'Memproses...';
        
        const formData = {
            new_password: document.getElementById('newPassword').value,
            new_password_confirmation: document.getElementById('newPasswordConfirmation').value,
        };

        try {
            const response = await fetch('/database-user/' + userId + '/reset-password', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (data.success) {
                const successMsg = document.getElementById('resetSuccessMessage');
                successMsg.textContent = data.message;
                successMsg.classList.add('show');
                
                document.getElementById('newPassword').value = '';
                document.getElementById('newPasswordConfirmation').value = '';
                
                setTimeout(() => {
                    closeModal('resetPasswordModal');
                    window.location.reload();
                }, 2000);
            } else {
                if (data.errors) {
                    for (const field in data.errors) {
                        const fieldName = field.replace(/_/g, '');
                        const errorElement = document.getElementById(fieldName + 'Error');
                        if (errorElement) {
                            errorElement.textContent = data.errors[field][0];
                            errorElement.classList.add('show');
                        }
                    }
                }
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Terjadi kesalahan. Silakan coba lagi.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'Reset Password';
        }
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.classList.remove('show');
            disableSelectionMode();
        }
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.modal').forEach(modal => {
                modal.classList.remove('show');
            });
            disableSelectionMode();
        }
    });
</script>
@endsection