import './styles.css';
import { definePterodactylExtension } from '@pterodactyl/sdk';
import DashboardBadge from './components/DashboardBadge';
import ServersColumn from './components/ServersColumn';

export default definePterodactylExtension({
    setup({ columns, screens, slots }) {
        screens.register('groups', () => import('./screens/GroupsScreen'));
        screens.register('admin', () => import('./screens/AdminScreen'));
        slots.register('dashboard.serverRow.name.after', DashboardBadge);
        columns.register('admin.servers', { id: 'groups', label: 'Groups', component: ServersColumn });
    },
});
