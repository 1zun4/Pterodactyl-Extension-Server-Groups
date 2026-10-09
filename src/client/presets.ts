const CONSOLE = ['websocket.connect', 'control.console', 'control.start', 'control.stop', 'control.restart'];
const READ = ['websocket.connect', 'file.read', 'file.read-content', 'backup.read', 'schedule.read', 'database.read', 'allocation.read', 'startup.read', 'activity.read'];
const OPERATOR = /^(websocket|control|file|backup|schedule|activity)\.|^(database|startup|allocation)\.read$/;

export const PRESETS = [
    { id: 'full', label: 'Full access', expand: (all: string[]) => [...all] },
    { id: 'operator', label: 'Operator', expand: (all: string[]) => all.filter((key) => OPERATOR.test(key)) },
    { id: 'console', label: 'Console only', expand: () => CONSOLE },
    { id: 'read', label: 'Read only', expand: () => READ },
] as const;

const same = (a: string[], b: string[]) => a.length === b.length && b.every((key) => a.includes(key));

/** The preset these permissions match, or "custom". */
export function presetOf(permissions: string[], all: string[]): string {
    return PRESETS.find((preset) => all.length > 0 && same(permissions, preset.expand(all)))?.id ?? 'custom';
}

export const presetLabel = (permissions: string[], all: string[]) => PRESETS.find((preset) => preset.id === presetOf(permissions, all))?.label ?? 'Custom';
