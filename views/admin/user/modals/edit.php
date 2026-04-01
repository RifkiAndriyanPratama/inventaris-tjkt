<div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeModal('modal-edit')"></div>
    <div class="relative bg-white rounded-2xl w-full max-w-md mx-4 shadow-2xl">
        <div class="flex items-center justify-between p-6 border-b border-default">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-brand/10 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-heading">Edit User</h3>
                    <p class="text-xs text-body/70 mt-0.5">Ubah data user yang sudah ada</p>
                </div>
            </div>
            <button onclick="closeModal('modal-edit')" class="text-body/40 hover:text-body transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form id="formEdit" action="/admin/user.php" method="POST" class="p-6 space-y-4">
            <input type="hidden" name="action" value="edit">
            <input type="hidden" name="id" id="edit-id">
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Nama User <span class="text-red-500">*</span></label>
                <input type="text" name="nama" id="edit-nama" required
                    class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition" />
            </div>
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">NIS <span class="text-red-500">*</span></label>
                <input type="text" name="nis" id="edit-nis" required
                    class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition" />
            </div>
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Kelas <span class="text-red-500">*</span></label>
                <select name="kelas" id="edit-kelas" class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
                    <option value="X TJKT A">X TJKT A</option>
                    <option value="X TJKT B">X TJKT B</option>
                    <option value="XI TJKT A">XI TJKT A</option>
                    <option value="XI TJKT B">XI TJKT B</option>
                    <option value="XII TJKT A">XII TJKT A</option>
                    <option value="XII TJKT B">XII TJKT B</option>
                </select>
            </div>
             <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Password (Kosongkan jika tidak ingin mengubah)</label>
                <input type="password" name="password" id="edit-password"
                    class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition" />
            </div>
            <div>
                <label class="block text-sm font-medium text-heading mb-1.5">Role</label>
                <select name="role" id="edit-role" class="w-full border border-default rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-brand/20 focus:border-brand transition">
                    <option value="">Pilih Role</option>
                    <option value="user">User</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
        </form>
        
        <div class="flex items-center justify-end space-x-3 p-6 border-t border-default bg-neutral-secondary-soft/50 rounded-b-2xl">
            <button type="button" onclick="closeModal('modal-edit')"
                class="px-4 py-2.5 text-sm font-medium text-body border border-default rounded-xl hover:bg-white transition-colors">
                Batal
            </button>
            <button type="submit" form="formEdit"
                class="px-4 py-2.5 text-sm font-medium text-white bg-brand hover:bg-brand-strong rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg shadow-brand/25">
                Update User
            </button>
        </div>
    </div>
</div>
