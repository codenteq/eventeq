import {Input, Select} from "@codenteq/interfeys";
import React, {useState} from "react";

export default function Step1({data, setData, cities}) {
    const Jobs = [
        'Akademisyen',
        'Doktor (Tıp hekimi)',
        'Diş hekimi',
        'Öğretmen',
        'Mühendis',
        'Kamu',
        'Serbest meslek Dernek müdürü'
    ];

    const [selectedJob, setSelectedJob] = useState('');

    return (
        <>
            <div className="my-5">
                <h3>Adım 1: Kişisel Bilgiler (Grup iseniz grup temsilcisinin bilgilerini giriniz)</h3>
            </div>
            <div className="grid gap-5 mb-6 lg:grid-cols-2">
                <Input
                    value={data.full_name}
                    onChange={(e) => setData('full_name', e.target.value)}
                    name="full_name"
                    type="text"
                    label="Tam adınız"
                    className="block w-full"
                />
                <Input
                    name="email"
                    value={data.email}
                    onChange={(e) => setData('email', e.target.value)}
                    type="email"
                    label="E-posta adresiniz"
                    className="block w-full"
                />
                <Input
                    name="phone"
                    value={data.phone}
                    onChange={(e) => setData('phone', e.target.value)}
                    type="tel"
                    label="Telefon numaranız"
                    className="block w-full"
                />
                <Input
                    name="birth_date"
                    value={data.birth_date}
                    onChange={(e) => setData('birth_date', e.target.value)}
                    type="number"
                    label="Doğum Yılınız"
                    className="block w-full"
                />
                <div>
                    <div className="mb-5">
                        <Select name="job" label="Mesleğiniz" placeholder="Lütfen Mesleğinizi Seçiniz"
                                value={data.job}
                                className="block w-full"
                                onChange={(e) => {
                                    setSelectedJob(e.target.value);
                                    setData('job', e.target.value);
                                }}
                        >
                            {Jobs.map((job, index) => (
                                <option key={index} value={job}>
                                    {job}
                                </option>
                            ))}
                            <option value="other">Diğer</option>
                        </Select>
                    </div>
                    {selectedJob === 'other' && (
                        <div>
                            <Input
                                name="job"
                                type="text"
                                label="Lütfen mesleğinizi belirtin"
                                className="block w-full"
                                onChange={(e) => setData('job', e.target.value)}
                            />
                        </div>
                    )}
                </div>
                <div>
                    <Select
                        name="city_id"
                        value={data.city_id}
                        onChange={(e) => setData('city_id', e.target.value)}
                        label="Şehir"
                        className="w-full"
                        placeholder="Lütfen Şehir Seçiniz">
                        {cities.map((city, index) => (
                            <option key={index} value={city.id}>
                                {city.name}
                            </option>
                        ))}
                    </Select>
                </div>
                <div>
                    <Select
                        name="transportation"
                        value={data.transportation}
                        onChange={(e) => setData('transportation', e.target.value)}
                        label="Etkinlik alanına ulaşımı nasıl sağlayacaksınız?"
                        className="w-full"
                        placeholder="Lütfen Ulaşım Aranıcınızı Seçiniz">
                        <option>
                            Özel Araçla
                        </option>
                        <option>
                            Toplu Taşıma
                        </option>
                    </Select>
                </div>
            </div>
        </>
    )
}
