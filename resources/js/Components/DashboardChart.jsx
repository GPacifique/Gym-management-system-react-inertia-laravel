import MemberCharts from '@/Components/Charts/MemberCharts';
import TrainerCharts from '@/Components/Charts/TrainerCharts';
import ManagerCharts from '@/Components/Charts/ManagerCharts';
import OwnerCharts from '@/Components/Charts/OwnerCharts';
import AdminCharts from '@/Components/Charts/AdminCharts';

export default function Dashboard({ auth }) {

    const role = auth.user.role;

    return (
        <div className="p-6">

            {role === 'member' && <MemberCharts />}

            {role === 'trainer' && <TrainerCharts />}

            {role === 'manager' && <ManagerCharts />}

            {role === 'owner' && <OwnerCharts />}

            {role === 'admin' && <AdminCharts />}

        </div>
    );
}