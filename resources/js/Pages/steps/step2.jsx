import {Button, Input, Select} from "@codenteq/interfeys";
import React, {useEffect, useState} from "react";

export default function Step2({data, setData}) {
    const [participants, setParticipants] = useState(data.participants);

    const handleParticipantChange = (id, event) => {
        const {name, value} = event.target;
        const updatedParticipants = participants.map(participant => {
            if (participant.id === id) {
                return {...participant, [name]: value};
            }
            return participant;
        });
        setParticipants(updatedParticipants);
    };

    const handleAddParticipant = () => {
        if (participants.length < 5) {
            const newId = participants.length + 1;
            setParticipants([...participants, {id: newId, full_name: '', birth_date: '', gender: null}]);
        }
    };

    const handleRemoveParticipant = (id) => {
        const updatedParticipants = participants.filter(participant => participant.id !== id);
        setParticipants(updatedParticipants);
    };

    useEffect(() => {
        setData('participants', participants);
    }, [participants]);

    return (
        <>
            <div className="my-5">
                <h3>Adım 2: Diğer Katılımcıların Bilgileri</h3>
                <p>Ebeveyni olduğunuz diğer katılımcıları bu kısımdan ekleyiniz. 18 yaşından büyük Katılımcılar için bu formu tekrar doldurunuz.</p>
            </div>
            {participants.map((participant) => (
                <div key={participant.id} className="grid gap-5 mb-6 lg:grid-cols-3 items-center">
                    <Input
                        name={`full_name`}
                        type="text"
                        label={`Katılımcı Tam Adı`}
                        className="block w-full"
                        value={participant.full_name}
                        onChange={(event) => handleParticipantChange(participant.id, event)}
                    />
                    <Input
                        name={`birth_date`}
                        type="number"
                        label={`Katılımcı Doğum Yılı`}
                        className="block w-full"
                        value={participant.birth_date}
                        onChange={(event) => handleParticipantChange(participant.id, event)}
                    />
                    <div>
                        <Select
                            name="gender"
                            value={participant.gender}
                            onChange={(event) => handleParticipantChange(participant.id, event)}
                            label="Cinsiyetiniz"
                            className="w-full"
                            placeholder="Lütfen Cinsiyetinizi Seçiniz">
                            <option>
                                Erkek
                            </option>
                            <option>
                                Kadın
                            </option>
                        </Select>
                    </div>
                    <div className="flex items-center">
                        <button type="button" className="text-left text-red-600"
                                onClick={() => handleRemoveParticipant(participant.id)}>
                            Sil
                        </button>
                    </div>
                </div>
            ))}
            {participants.length < 5 && (
                <div className="flex justify-end mb-6">
                    <Button type="button" label="Katılımcı Ekle" onClick={handleAddParticipant}/>
                </div>
            )}
        </>
    )
}
