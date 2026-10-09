import { expect, test } from 'vitest';
import { PRESETS, presetOf } from './presets';

const all = ['websocket.connect', 'control.console', 'control.start', 'control.stop', 'control.restart', 'file.read', 'file.update', 'user.create', 'startup.read', 'database.read', 'database.view_password'];

test('recognises presets by their exact permission set', () => {
    expect(presetOf(all, all)).toBe('full');
    expect(presetOf(PRESETS[1].expand(all), all)).toBe('operator');
    expect(PRESETS[1].expand(all)).not.toContain('user.create');
    expect(PRESETS[1].expand(all)).not.toContain('database.view_password');
    expect(presetOf(['control.console', 'websocket.connect', 'control.start', 'control.stop', 'control.restart'], all)).toBe('console');
    expect(presetOf(['file.read'], all)).toBe('custom');
});
