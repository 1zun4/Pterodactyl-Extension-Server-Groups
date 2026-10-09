import { afterEach, expect, test, vi } from 'vitest';
import { cleanup, render, screen } from '@testing-library/react';
import { createExtensionTestHost } from '@pterodactyl/sdk/testing';
import AdminScreen from './AdminScreen';

vi.mock('../api', async (importOriginal) => ({
    ...(await importOriginal<typeof import('../api')>()),
    getPermissionKeys: vi.fn().mockResolvedValue([{ key: 'control.console', description: '' }]),
    getAdmin: vi.fn().mockResolvedValue({
        groups: [
            {
                id: 1,
                name: 'Survival',
                color: '#22c55e',
                servers: [{ id: 3, name: 'Lobby' }],
                members: [{ user: 7, username: 'alex', email: 'alex@example.com', permissions: ['control.console'] }],
            },
        ],
        servers: [{ id: 3, name: 'Lobby', identifier: 'abcd1234' }],
    }),
}));

afterEach(cleanup);

test('lists groups with their servers and members', async () => {
    const host = createExtensionTestHost({ extensionId: 'server-groups', prefix: 'sgr' });
    render(<AdminScreen />, { wrapper: host.Wrapper });

    expect(await screen.findByText('Survival')).toBeTruthy();
    expect(screen.getByText('Lobby')).toBeTruthy();
    expect(screen.getByText('alex')).toBeTruthy();
    expect(await screen.findByText('Full access')).toBeTruthy();
    host.dispose();
});
