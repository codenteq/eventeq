import {Button, Input, Select} from "@codenteq/interfeys";
import React, {useState} from "react";

export default function Step1({ onNext }) {
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
    const [otherJob, setOtherJob] = useState('');

    const handleJobChange = (event) => {
        const { value } = event.target;
        setSelectedJob(value);
    };

    const handleOtherJobChange = (event) => {
        const { value } = event.target;
        setOtherJob(value);
    };

    const handleNextClick = () => {
        console.log('Sonraki butona tıklandı!');
        onNext();
    };
    return (
        <>
            <div className="grid gap-5 mb-6 lg:grid-cols-2">
                <Input
                    name="full_name"
                    type="text"
                    label="Tam adınız"
                    className="block w-full"
                />
                <Input
                    name="email"
                    type="email"
                    label="E-posta adresiniz"
                    className="block w-full"
                />
                <Input
                    name="phone"
                    type="tel"
                    label="Telefon numaranız"
                    className="block w-full"
                />
                <Input
                    name="birth_date"
                    type="date"
                    label="Doğum tarihiniz"
                    className="block w-full"
                />
                <div>
                    <div className="mb-5">
                        <Select name="job" label="Mesleğiniz" defaultValue="Choose" className="block w-full"
                                onChange={handleJobChange}>
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
                                value={otherJob}
                                onChange={handleOtherJobChange}
                            />
                        </div>
                    )}
                </div>
                <div>
                    <Select
                        name="city_id"
                        label="Şehir"
                        className="w-full"
                        placeholder="Choose">
                        <option value="01">Adana</option>
                    </Select>
                </div>
            </div>
            <div className="flex justify-end">
                <Button type="submit" label="Sonraki" onClick={handleNextClick}/>
            </div>
        </>
    )
}
