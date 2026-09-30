<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h2 class="fw-bold text-dark mb-1">User & Staff Accounts</h2>
        <p class="text-secondary mb-0">System operators, cashiers, and administrative access levels.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <span class="badge bg-white text-secondary border px-3 py-2 rounded-3 shadow-sm">
            <i class="bi bi-shield-lock me-1 text-info"></i> <?= esc(count($users ?? [])) ?> Staff Accounts
        </span>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-3 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-4 py-3" style="width: 100px;">User ID</th>
                    <th class="py-3">Full Name</th>
                    <th class="py-3">Terminal Handle</th>
                    <th class="py-3">Assigned Role</th>
                    <th class="py-3">Attendance</th>
                    <th class="py-3">Verification</th>
                    <th class="py-3 text-end pe-4">Access Level</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users) && is_array($users)): ?>
                    <?php foreach ($users as $user): ?>
                        <?php
                            $roleClass = match ($user['role']) {
                                'Admin'         => 'bg-danger-subtle text-danger border border-danger-subtle',
                                'Store Manager' => 'bg-primary-subtle text-primary border border-primary-subtle',
                                'Cashier'       => 'bg-success-subtle text-success border border-success-subtle',
                                'Inventory'     => 'bg-info-subtle text-info border border-info-subtle',
                                default         => 'bg-secondary-subtle text-secondary border border-secondary-subtle',
                            };
                            $accessLevel = match ($user['role']) {
                                'Admin'         => 'Full Access',
                                'Store Manager' => 'Management Access',
                                'Cashier'       => 'View Only',
                                'Inventory'     => 'Inventory Access',
                                default         => 'No Access',
                            };
                            $attendanceClass = match (strtolower((string) $user['attendance_status'])) {
                                'clocked in'  => 'bg-success-subtle text-success',
                                'clocked out' => 'bg-secondary-subtle text-secondary',
                                'pto'         => 'bg-primary-subtle text-primary',
                                'awol'        => 'bg-danger-subtle text-danger',
                                default       => 'bg-light text-secondary',
                            };
                            $isVerified = (bool) $user['is_verified'];
                        ?>
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-dark border font-monospace">UID-0<?= esc($user['id']) ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <span class="avatar-circle bg-dark-subtle text-dark">
                                        <?= esc(strtoupper(substr((string) $user['full_name'], 0, 1))) ?>
                                    </span>
                                    <span class="fw-semibold text-dark"><?= esc($user['full_name']) ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-dark-subtle text-dark font-monospace fw-normal">
                                    @<?= esc($user['username']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-1 <?= esc($roleClass, 'attr') ?>">
                                    <?= esc($user['role']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge rounded-pill px-3 py-1 <?= esc($attendanceClass, 'attr') ?>">
                                    <?= esc($user['attendance_status']) ?>
                                </span>
                            </td>
                            <td>
                                <span class="badge <?= $isVerified ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning-emphasis' ?>">
                                    <?= esc($isVerified ? 'Verified' : 'Not Verified') ?>
                                </span>
                            </td>
                            <td class="text-end pe-4">
                                <span class="badge bg-light text-secondary border"><?= esc($accessLevel) ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2 text-secondary"></i>
                            No user accounts found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
