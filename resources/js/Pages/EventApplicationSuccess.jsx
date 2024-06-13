import MainLayout from "../Layouts/MainLayout.jsx";
import {Link} from "@inertiajs/react";
import {Button} from "@codenteq/interfeys";

export default function EventApplicationSuccess({application}) {
    return (
        <MainLayout>
            <section className="bg-white py-8 antialiased">
                <div className="mx-auto max-w-2xl px-4 2xl:px-0">
                    <h2 className="text-xl font-semibold text-green-500 sm:text-2xl mb-2">
                        Başarılı bir şekilde kaydınız gerçekleştirildi
                    </h2>
                    <h3 className="text-green-500 font-semibold mb-2">
                        Başvuru Numaranız : {application?.id}
                    </h3>
                    <p className="text-blue-500 font-semibold mb-2">
                        Lütfen Başvuru numaranızı Check-in sırasında kullanmak saklayınız.  Size bu numara eposta ile de gönderilmiştir.
                    </p>
                    <div>
                        <h4 className="text-gray-800 mb-6 md:mb-8">
                            {application.event.name} Etkinlik Detayı
                        </h4>
                        <div
                            className="space-y-4 sm:space-y-2 rounded-lg border border-gray-100 bg-gray-50 p-6 mb-6 md:mb-8">
                            <dl className="sm:flex items-center justify-between gap-4">
                                <dt className="font-normal mb-1 sm:mb-0 text-gray-500">Başvuran Ad Soyad</dt>
                                <dd className="font-medium text-gray-900 sm:text-end">{application?.user?.name}</dd>
                            </dl>
                            <dl className="sm:flex items-center justify-between gap-4">
                                <dt className="font-normal mb-1 sm:mb-0 text-gray-500">E-posta</dt>
                                <dd className="font-medium text-gray-900 sm:text-end">{application?.user?.email}</dd>
                            </dl>
                            <dl className="sm:flex items-center justify-between gap-4">
                                <dt className="font-normal mb-1 sm:mb-0 text-gray-500">Telefon</dt>
                                <dd className="font-medium text-gray-900 sm:text-end">{application?.user?.phone}</dd>
                            </dl>
                            <dl className="sm:flex items-center justify-between gap-4">
                                <dt className="font-normal mb-1 sm:mb-0 text-gray-500">Meslek</dt>
                                <dd className="font-medium text-gray-900 sm:text-end">{application.job}</dd>
                            </dl>
                            <dl className="sm:flex items-center justify-between gap-4">
                                <dt className="font-normal mb-1 sm:mb-0 text-gray-500">Varış Tarihi</dt>
                                <dd className="font-medium text-gray-900 sm:text-end">{application.arrival_date}</dd>
                            </dl>
                            <dl className="sm:flex items-center justify-between gap-4">
                                <dt className="font-normal mb-1 sm:mb-0 text-gray-500">Ayrılış Tarihi</dt>
                                <dd className="font-medium text-gray-900 sm:text-end">{application.departure_date}</dd>
                            </dl>
                        </div>
                    </div>
                    <div>
                        <h4
                            className="text-gray-800 mb-6 md:mb-8">
                            Katılımcı Bilgileri
                        </h4>
                        {application?.group?.child?.map((child, index) => (
                            <div
                                key={index}
                                className="space-y-4 sm:space-y-2 rounded-lg border border-gray-100 bg-gray-50 p-6 mb-6 md:mb-8">
                                <dl className="sm:flex items-center justify-between gap-4">
                                    <dt className="font-normal mb-1 sm:mb-0 text-gray-500">Katılımcı Ad Soyad</dt>
                                    <dd className="font-medium text-gray-900 sm:text-end">{child.full_name}</dd>
                                </dl>
                                <dl className="sm:flex items-center justify-between gap-4">
                                    <dt className="font-normal mb-1 sm:mb-0 text-gray-500">Katılımcı Doğum Yılı
                                    </dt>
                                    <dd className="font-medium text-gray-900 sm:text-end">{new Date(child.birth_date).getFullYear()}</dd>
                                </dl>
                            </div>
                        ))}
                    </div>
                </div>
                <div className="flex items-center justify-center space-x-4">
                    <Link href={`/events/` + application.event_id}>
                       <Button type='button' label=' Etlinliğe Geri Dön' className='w-full'/>
                    </Link>
                </div>
            </section>
        </MainLayout>
    )
}
