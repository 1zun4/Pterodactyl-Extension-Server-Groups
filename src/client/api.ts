import { http } from '@pterodactyl/sdk';

export interface ClientGroup {
    id: number;
    name: string;
    color: string;
    servers: { identifier: string; uuid: string; name: string; description: string | null }[];
}

export interface Member {
    user: number;
    username: string;
    email: string;
    permissions: string[];
}

export interface AdminGroup {
    id: number;
    name: string;
    color: string;
    servers: { id: number; name: string }[];
    members: Member[];
}

export interface AdminData {
    groups: AdminGroup[];
    servers: { id: number; name: string; identifier: string }[];
    sync?: { created: number; updated: number; removed: number; skipped: number; failed: number };
}

export interface GroupInput {
    id?: number;
    name: string;
    color: string;
    servers: number[];
    members: { user: number; permissions: string[] }[];
}

const admin = '/api/admin/extensions/server-groups';

export const keys = {
    client: ['server-groups', 'client'] as const,
    admin: ['server-groups', 'admin'] as const,
    adminServers: ['server-groups', 'admin', 'servers'] as const,
    permissions: ['server-groups', 'permissions'] as const,
    users: (query: string) => ['server-groups', 'users', query] as const,
};

export const getClientGroups = async () => (await http.get<{ groups: ClientGroup[] }>('/api/client/extensions/server-groups/groups')).data.groups;
export const getAdmin = async () => (await http.get<AdminData>(`${admin}/groups`)).data;
export const saveGroup = async (group: GroupInput) =>
    group.id ? (await http.put<AdminData>(`${admin}/groups/${group.id}`, group)).data : (await http.post<AdminData>(`${admin}/groups`, group)).data;
export const deleteGroup = async (id: number) => (await http.delete<AdminData>(`${admin}/groups/${id}`)).data;
export const syncGroups = async () => (await http.post<AdminData>(`${admin}/sync`)).data;
export const searchUsers = async (query: string) =>
    (await http.get<{ users: { id: number; username: string; email: string }[] }>(`${admin}/users`, { params: { query } })).data.users;
export const getServerGroups = async () =>
    (await http.get<{ servers: Record<string, { id: number; name: string; color: string }[]> }>(`${admin}/servers`)).data.servers;

/** Every subuser permission key the panel knows, including those of other extensions. */
export async function getPermissionKeys(): Promise<{ key: string; description: string }[]> {
    const { data } = await http.get<{ attributes: { permissions: Record<string, { keys: Record<string, string> }> } }>('/api/client/permissions');

    return Object.entries(data.attributes.permissions).flatMap(([group, { keys: permissions }]) =>
        Object.entries(permissions).map(([key, description]) => ({ key: `${group}.${key}`, description }))
    );
}
