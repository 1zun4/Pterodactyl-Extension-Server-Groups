import { useQuery } from '@tanstack/react-query';
import type { ExtensionTableRows } from '@pterodactyl/sdk';
import { getServerGroups, keys } from '../api';
import GroupPill from './GroupPill';

export default function ServersColumn({ data }: { data: ExtensionTableRows['admin.servers'] }) {
    const groups = useQuery({ queryKey: keys.adminServers, queryFn: getServerGroups, staleTime: 60_000 });

    return (
        <span className='sgr:flex sgr:flex-wrap sgr:gap-1'>
            {(groups.data?.[String(data.attributes.id)] ?? []).map((group) => (
                <GroupPill key={group.id} name={group.name} color={group.color} />
            ))}
        </span>
    );
}
