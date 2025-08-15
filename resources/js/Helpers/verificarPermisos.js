document.addEventListener("alpine:init", () => {
    Alpine.data("combinedAccess", () => ({
        sidebarOpen: true,
        roles: JSON.parse(localStorage.getItem("roles") || "[]"),
        permissions: JSON.parse(localStorage.getItem("permissions") || "[]"),
        hasRole(roleName) {
            return this.roles.includes(roleName);
        },
        hasAnyRole(...roles) {
            return roles.some((role) => this.roles.includes(role));
        },
        hasPermission(permissionName) {
            return this.permissions.includes(permissionName);
        },
        hasAnyPermission(...permissions) {
            return permissions.some((permission) =>
                this.permissions.includes(permission)
            );
        },
    }));
});
