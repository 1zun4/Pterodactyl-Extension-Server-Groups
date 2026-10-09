import { useQuery } from '@tanstack/react-query';
import { PageContentBlock, PanelLink, Spinner, TitledGreyBox, httpErrorToHuman } from '@pterodactyl/sdk';
import { getClientGroups, keys } from '../api';
import GroupTitle from '../components/GroupTitle';

export default function GroupsScreen() {
    const groups = useQuery({ queryKey: keys.client, queryFn: getClientGroups });

    return (
        <PageContentBlock title='Server Groups'>
            {groups.isLoading ? (
                <Spinner centered size={Spinner.Size.LARGE} />
            ) : groups.isError ? (
                <p className='sgr:text-sm sgr:text-destructive'>{httpErrorToHuman(groups.error)}</p>
            ) : groups.data!.length === 0 ? (
                <p className='sgr:py-8 sgr:text-center sgr:text-sm sgr:text-muted-foreground'>None of your servers is in a group.</p>
            ) : (
                <div className='sgr:grid sgr:gap-6 sgr:md:grid-cols-2'>
                    {groups.data!.map((group) => (
                        <TitledGreyBox
                            key={group.id}
                            title={<GroupTitle name={group.name} color={group.color} />}
                        >
                            <ul className='sgr:grid sgr:gap-1'>
                                {group.servers.map((server) => (
                                    <li key={server.uuid}>
                                        <PanelLink
                                            destination={{ to: '/server/$id', params: { id: server.identifier } }}
                                            className='sgr:block sgr:rounded-sm sgr:px-2 sgr:py-1.5 sgr:text-sm sgr:text-foreground sgr:no-underline sgr:hover:bg-muted'
                                        >
                                            {server.name}
                                            {server.description && <span className='sgr:ml-2 sgr:text-xs sgr:text-muted-foreground'>{server.description}</span>}
                                        </PanelLink>
                                    </li>
                                ))}
                            </ul>
                        </TitledGreyBox>
                    ))}
                </div>
            )}
        </PageContentBlock>
    );
}
